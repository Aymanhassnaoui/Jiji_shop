<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produits;
use App\Entity\NewProduits;
use App\Entity\User;
use App\Form\RechercheType;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class PageController extends AbstractController
{
  private  $entityManager;
  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }
  /**
   * @Route("/", name="app_page")
   */
  public function index(Request  $request): Response
  {
 
    $produits = $this->entityManager->getRepository(NewProduits::class)
    ->findBy([], ['photo' => 'desc', 'prix' => 'desc']);


    return $this->render(
      'page/accueil.html.twig',
      [
       
         "produits" => $produits,

      ]
    );
  }

  /**
   * @Route("/contact", name="app_produits")
   */

  public function Contact(MailerInterface $mailer): Response
  {
    $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

    



    return $this->render(
      'contact/contact.html.twig',
      [
        
      ]
    );
  }




  /**
   * @Route("/about", name="app")
   */
  public function about(): Response
  {
    return $this->render(
      'page/about.html.twig',
    );
  }





   /**
   * @Route("/showNewproduit/{id}", name="NewProduit")
   */
  public function showNewProduits($id): Response
  {

    $repo = $this->entityManager->getRepository(NewProduits::class);
    $produit = $repo->find($id);


    return $this->render(
      'produit/show.html.twig',
      [
        "produit" => $produit,


      ]
    );
  }
}
