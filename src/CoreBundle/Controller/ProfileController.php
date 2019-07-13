<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CoreBundle\Entity\User;

class ProfileController extends Controller
{


    /**
     * @Route("/profile", name="profile")
     */
    public function adminPanel()
    {


        $user = $this->getUser();
        $role = $user->getRoles();
        $user_name = $user->getName() . " " . $user->getSurname();
        $repository_user = $this->getDoctrine()->getRepository(User::class);
        $user = $repository_user->findById($user->getId());

        return $this->render('@Core/Default/Profile/profile.html.twig', ['role' => $role, 'user_name' => $user_name, 'user_info' => $user]);
    }
}
