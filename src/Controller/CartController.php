<?php

namespace App\Controller;

use App\classe\cart;

use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private  $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/mon-panier", name="app_cart")
     */
    public function index(cart $cart): Response
    {
      


        return $this->render(
            'cart/index.html.twig',
            [
                'cart' => $cart->getfull()
            ]
        );
    }
    /**
     * @Route("/cart/add/{id}", name="add_cart")
     */
    public function add(cart $cart, $id ,Request $request)

    {
        $quantity = $request->query->get('quantity', 1);

    
        $cart->add($id, $quantity);

        return $this->redirectToRoute('app_cart');
    }


    /**
     * @Route("/cart/delete", name="cart_delete")
     */
    public function clear(Cart $cart) : Response
    {
        $cart->clear();

        return $this->redirectToRoute('app_cart');
    }
}
