<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CoreBundle\Entity\Glasses;

class ShopCartController extends Controller
{
    /**
     * @Route("/ShopCart", name="shop_cart")
     */
    public function ShowCart()
    {
        $cart =  $this->get('session')->get('Cart');

        $user = $this->getUser();
        $role = $user->getRoles();
        $array_glasses = [];
        $repository_glasses = $this->getDoctrine()->getRepository(Glasses::class);
        $total = 0;
        if ($cart) {
            for ($i = 0; $i < sizeof($cart); $i++) {

                $glasses = $repository_glasses->findById($cart[$i][0]);
                $subtotal = $glasses[0]->getPrice() * $cart[$i][1];
                $total = $total + $glasses[0]->getPrice() * $cart[$i][1];
                $glasses[0]->setSubtotal($subtotal);
                $glasses[0]->setCartQuantity($cart[$i][1]);
                array_push($array_glasses, $glasses);
            }
        }

        if ($user) {

            $user_name = $user->getName() . " " . $user->getSurname();
        } else {
            $user_name = "Guest";
        }

        return $this->render('@Core/Default/Shop/shopcart.html.twig', ['role' => $role, 'user_name' => $user_name, 'glasses' => $array_glasses, 'total' => $total]);
    }

    /**
     * @Route("/addCart/{id}", name="add_to_cart")
     *
     */
    public function AddToCart(Request $request)
    {
        $id = $request->attributes->get('id');
        $repository = $this->getDoctrine()->getRepository(Glasses::class);
        $glasses = $repository->findById($id);
        if (!$this->get('session')->get('Cart')) {

            $array = [];
            array_push($array, [$id, 1]);
            $this->get('session')->set('Cart', $array);
        } else {
            $cart = $this->get('session')->get('Cart');

            /* if (sizeof($cart) === 1) {
                dump($cart[8]);
            }*/
            $cont_same_product = 0;
            for ($i = 0; $i < sizeof($cart); $i++) {
                if ($cart[$i][0] === $id) {

                    $cart[$i][1] = ++$cart[$i][1];
                    $cont_same_product = 1;
                }
            }

            if ($cont_same_product === 0) {

                array_push($cart, [$id, 1]);
            }
            // $this->get('session')->remove('Cart');
            $this->get('session')->set('Cart', $cart);
            //  $tiny_array = array($id => "1");
            // $array = array_merge($cart, $tiny_array);
        }



        //  $user->setCart([$id]);



        $user = $this->getUser();
        if ($user) {
            $user_name = $user->getName() . " " . $user->getSurname();
        } else {
            $user_name = "Guest";
        }
        // return $this->render('@Core/Default/Shop/shopcart.html.twig', ['user_name' => $user_name]);
        return $this->redirectToRoute('shop_cart');
    }


    /**
     * @Route("/updateCart", name="update_cart")
     *
     */
    public function updateCart(Request $request)
    {
        $id_glass = $_GET['id'];
        $quantity = $_GET['quantity'];
        $cart = $this->get('session')->get('Cart');

        for ($i = 0; $i < sizeof($cart); $i++) {
            if ($cart[$i][0] === $id_glass) {
                if ($quantity > 0) {
                    $cart[$i][1] = $quantity;
                } else {

                    array_splice($cart, $i, 1);
                }
            }
        }
        $this->get('session')->set('Cart', $cart);

        return new Response($quantity);
    }


    /**
     * @Route("/deleteCart", name="delete_cart")
     *
     */
    public function deleteCart()
    {

        $id_glass = $_GET['id'];
        $quantity = $_GET['quantity'];
        $cart = $this->get('session')->get('Cart');

        for ($i = 0; $i < sizeof($cart); $i++) {
            if ($cart[$i][0] === $id_glass) {


                array_splice($cart, $i, 1);
            }
        }
        $this->get('session')->set('Cart', $cart);

        return new Response($quantity);
    }
}
