<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
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

            $user_name = $user->getName() . " " . $user->getSurname();
        } else {
            $user_name = "Guest";
        }
        return $this->render('@Core/Default/Shop/home.html.twig', ['user_name' => $user_name, 'glasses' => $glasses]);
    }

    /**
     * @Route("/product/{id}", name="product_detail")
     */

    public function showGlass(Request $request)
    {
        $id = $request->attributes->get('id');
        $repository = $this->getDoctrine()->getRepository(Glasses::class);
        $glasses = $repository->findById($id);
        $user = $this->getUser();
        if ($user) {

            $user_name = $user->getName() . " " . $user->getSurname();
        } else {
            $user_name = "Guest";
        }
        // $glasses->get('imgRoute');

        return $this->render('@Core/Default/Shop/glass.html.twig', ['glass_desc' => $glasses, 'user_name' => $user_name]);
    }
}
