<?php

namespace App\Controller;


use App\Entity\Produits;
use App\Entity\Avis;
use App\Form\AvisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
class ProduitController extends AbstractController
{


    private  $entityManager;
    public function __construct( EntityManagerInterface $entityManager)
   {
     $this->entityManager=$entityManager;    
   }



    #[Route('/produit', name: 'app_produit')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {


        $data= $this->entityManager->getRepository(Produits::class)->findAll();
        $produits = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), 
            6 
        );      
        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
        ]);
    }


    #[Route('/produit/{id}', name: 'show_produit')]
    public function showproduit(  Request $request , int $id,PaginatorInterface $paginator): Response
    {    


        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        $produit = $this->entityManager->getRepository(Produits::class)->find($id);
            $avisproduits = $this->entityManager->getRepository(Avis::class)->findBy(['produits' => $produit]);
             $produitspaginate = $paginator->paginate(
                $avisproduits,
                $request->query->getInt('page', 1), 
                5
            ); 
        
            $countavisproduits =  count($avisproduits);

        if ($user = $this->getUser()) {
         
           
            $form->handleRequest($request);

           
            $userNom = $user->getNom();
            $userPrenom = $user->getPrenom();
            
           
            $date = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));

            if ($form->isSubmitted() && $form->isValid()) {
                // Définir les propriétés de l'avis
                $avis->setNomPrenom($userNom . " " . $userPrenom);
                $avis->setCreatedAt($date);
                $avis->setProduits($produit );
                // Persister l'avis dans la base de données
                $this->entityManager->persist($avis);
                $this->entityManager->flush();
            }}
   
           
     
  
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
            'avisproduits' => $avisproduits,
            'avisproduits' => $produitspaginate,
            'countavisproduits' =>$countavisproduits
            
        ]);
    }



   
}
