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
        $form = $this->createForm(CommandeType::class, null ,[
            'user' => $this->getUser(),
          
        ]);

        $form->handleRequest($request);
       

        return $this->render('commande/index.html.twig', [
            'form'=>$form->createView(),
            'cart'=>$cart->getfull(),
                   ]);
    }

   /**
 * @Route("/chekout", name="app_reservation")
 */
public function chekout(cart $cart, Request $request) 
{   
    $chekout = new Chekout();
    $form = $this->createForm(ChekoutType::class, $chekout);
    
    $form->handleRequest($request);
    $date = new \DateTime();
    $reference = $date->format('dmy') . '-' . uniqid();
    $chekout->setReference($reference);
    
    if ($form->isSubmitted() && $form->isValid()) {
        foreach ($cart->getfull() as $Produits) {
            $chekout = new Chekout(); // Nouvelle instance pour chaque produit
            $chekout->setUser($this->getUser());
           
            $chekout->setReference($reference);
            $chekout->setProduit($Produits['produit']);
            $chekout->setQuantity($Produits['quantity']);
            $chekout->setPrix($Produits['produit']->getPrix());
            $chekout->setTotal($Produits['produit']->getPrix() * $Produits['quantity']);
            $chekout->setNom('Nom par défaut'); // Vous pouvez remplacer par la valeur appropriée
            $chekout->setPrenom('Prenom par défaut');
            
            $this->entityManager->persist($chekout);
        }
        $this->entityManager->flush();
        return $this->redirectToRoute('app_commande');
    }
    
    return $this->render('reservation/reservation.html.twig', [
        'form' => $form->createView(),
        'cart' => $cart->getfull(),
        'reference' => $chekout->getReference()
    ]);
}


}
