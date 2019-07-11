<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use CoreBundle\Entity\Glasses;

class ShopController extends Controller
{

    /**
     * @Route("/")
     */
    public function showMain()
    {
        $repository = $this->getDoctrine()->getRepository(Glasses::class);
        $glasses = $repository->findAll();

        $user = $this->getUser();
        if ($user) {
            $surname = $this->get('session')->get('surname');
            $user_name = $user->getName() . " " . $user->getSurname();
        } else {
            $user_name = "Guest";
        }
        return $this->render('@Core/Default/Shop/home.html.twig', ['user_name' => $user_name, 'glasses' => $glasses]);
    }
}
