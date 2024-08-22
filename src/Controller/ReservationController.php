<?php

namespace App\Controller;

use App\classe\cart;
use App\Entity\Produits;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Form\ReserverType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class ReservationController extends AbstractController
{
     private  $entityManager;
  public function __construct( EntityManagerInterface $entityManager)
 {
   $this->entityManager=$entityManager;    
 }
   
    
}
