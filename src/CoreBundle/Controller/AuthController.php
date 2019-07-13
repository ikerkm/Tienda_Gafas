<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use CoreBundle\Form\UserType;
use CoreBundle\Entity\User;

class AuthController extends Controller
{



    /**
     * @Route("/login", name="login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {


        $error = $authenticationUtils->getLastAuthenticationError();


        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@Core/Default/Auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }



    /**
     * @Route("/register", name="register_page")
     */
    public function RegisterAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {


        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('register_page', array('id' => $user->getId()));
        }
        return $this->render('@Core/Default/Auth/register.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/register_save")
     * @Method("POST")
     */
    public function Save_user(Request $request)
    {


        $passwordEncoder = $this->get('security.password_encoder');
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }
        return $this->render('TimeBundle:user:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }
}
