<?php
namespace App\classe;

use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;

class cart 

{
    private $session;  private  $entityManager;
    

    public function __construct(   EntityManagerInterface $entityManager,SessionInterface $session )
    {
       $this->session=$session; 
       $this->entityManager=$entityManager;
    }
    public function add($id   ,$quantity = 1)
    {   
      $cart = $this->session->get('cart', []);
      if (!empty($cart[$id])) {
          $cart[$id] += $quantity;
      } else {
          $cart[$id] = $quantity;
      }


         
          $this->session->set('cart',$cart);  
            }
    public function get() {
        return $this->session->get('cart');
    }

    public function getfull(){
      $cartcomplete = []  ;
        foreach ((array)$this->get() as $id => $quantity)
        $cartcomplete[]= [
            'produit' => $this->entityManager->getRepository(Produits::class)->findOneById($id),
             'quantity' => $quantity
        ];  
        return $cartcomplete;
    }
   
    public function clear()
    {
        $this->session->remove('cart');
    }
   
}

?> 