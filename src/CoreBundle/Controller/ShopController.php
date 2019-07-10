<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ShopController extends Controller
{

    /**
     * @Route("/")
     */
    public function indexAction()
    {


        $name = $this->get('session')->get('name');
        $surname = $this->get('session')->get('surname');
        $user_name = $name . " " . $surname;
        return $this->render('@Core/Default/Shop/home.html.twig', ['user_name' => $user_name]);
    }
}
