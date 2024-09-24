<?php

namespace App\Controller;

use App\classe\cart;
use App\Form\ChekoutType;
use App\Entity\Chekout;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CommandeController extends AbstractController
{

    private  $entityManager;
    public function __construct( EntityManagerInterface $entityManager)
   {
     $this->entityManager=$entityManager;    
   }


    #[Route('/commande', name: 'app_commande')]
    public function index( cart $cart , Request $request): Response
    {
      $user = $this->getUser();

    // Récupérer les informations de la commande en cours depuis la session ou la base de données
    $chekout = $this->entityManager->getRepository(Chekout::class)->findOneBy(['user' => $user], ['id' => 'DESC']);
    
    // Si aucune commande n'existe encore, rediriger vers la page de checkout
    if (!$chekout) {
        return $this->redirectToRoute('app_reservation');
    } 
  
    $produits = $cart->getfull();

        
        return $this->render('commande/index.html.twig', [
          'nom' => $chekout->getNom(),
        'prenom' => $chekout->getPrenom(),
        'adresse' => $chekout->getAdresse(),
        'quantity' => $chekout->getquantity(),
        
            
                   ]);
    }

   /**
 * @Route("/chekout", name="app_reservation")
 */
public function chekout(cart $cart, Request $request) 
{   
 


  if (!$cart->getfull()) {
    return $this->redirectToRoute('app_cart');
} 

    $chekout = new Chekout();
    $form = $this->createForm(ChekoutType::class, $chekout);
    
    $form->handleRequest($request);
  

    
    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();     
      

      foreach ($cart->getfull() as $Produits) {

              $chekout->setUser($this->getUser());

              $existingChekout = $this->entityManager->getRepository(Chekout::class)->findOneBy([
                'user' => $this->getUser(),
                'produit' => $Produits['produit']
            ]);
            if ($existingChekout) {
            
              $chekout = $existingChekout;
          } 
           
            $chekout->setProduit($Produits['produit']);
            $chekout->setQuantity($Produits['quantity']);
            $chekout->setPrix($Produits['produit']->getPrix());
            $chekout->setTotal($Produits['produit']->getPrix() * $Produits['quantity']);
           
            $chekout->setNom($data->getNom());
            $chekout->setPrenom($data->getPrenom());
            $chekout->setAdresse($data->getAdresse());

            $chekout->setNumeroTelephone($data->getNumeroTelephone());
            $chekout->setEmail($data->getEmail());
            $chekout->setDesAdresse($data->getDesAdresse());
            $date = new \DateTime();
            $reference = $date->format('dmy') . '-' . uniqid();
            $chekout->setReference($reference);
            
            $this->entityManager->persist($chekout);
        }
      
        $this->entityManager->flush();
        return $this->redirectToRoute('app_commande');
    }
    
    return $this->render('reservation/reservation.html.twig', [
        'form' => $form->createView(),
        'cart' => $cart->getfull(),
        'reference' => $chekout->getReference(),
  
    ]);
}


}
