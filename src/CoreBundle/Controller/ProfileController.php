<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use CoreBundle\Entity\User;
use CoreBundle\Form\UserType;

class ProfileController extends Controller
{


    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $user = $this->getUser();
        $role = $user->getRoles();
        $user_name = $user->getName() . " " . $user->getSurname();
        $repository_user = $this->getDoctrine()->getRepository(User::class);
        $user_info = $repository_user->findById($user->getId());





        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $is_match = $passwordEncoder->isPasswordValid($user, $user->getPlainPassword());


            if ($is_match == true) {

                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('profile');
            }
            if ($is_match == false) {

                $error_pass = "Wrong password";
                return $this->render('@Core/Default/Profile/profile.html.twig', array(
                    'role' => $role, 'user_name' => $user_name, 'user_info' => $user_info, 'error_pass' => $error_pass,
                    'form' => $form->createView(),
                ));
            }
        }
        return $this->render('@Core/Default/Profile/profile.html.twig', array(
            'role' => $role, 'user_name' => $user_name, 'user_info' => $user_info, 'error_pass' => null,
            'form' => $form->createView(),
        ));
    }
}
