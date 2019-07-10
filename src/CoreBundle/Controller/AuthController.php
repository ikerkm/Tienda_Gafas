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

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@Core/Default/Auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
    /*   public function ShowLogin()
    {
        return $this->render('@Core/Default/Auth/login.html.twig', [
            'last_username' => null,
            'error'         => null,
        ]);
    }*/
    /**
     * @Route("/logg")
     * @Method("POST")
     */

    /*  public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@Core/Default/Auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }*/



    /* public function GetCred(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:User');
        return new Response("Login");
        //Creamos usuario

        //return $this->render('@Core/Default/Auth/login.html.twig');
    }

*/


    /**
     * @Route("/register", name="register_page")
     */
    public function RegisterAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        //$em = $this->getDoctrine()->getManager();
        // $repository = $em->getRepository('CoreBundle:User');
        //  var_dump($request->get('mail'));
        // $passwordEncoder = $this->get('security.password_encoder');
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
    /* public function ShowRegister()
    {
        return $this->render('@Core/Default/Auth/register.html.twig', ['mail_err' => null, 'pass_err' => null]);
    }*/

    /**
     * @Route("/register_save")
     * @Method("POST")
     */
    public function Save_user(Request $request)
    {

        //$em = $this->getDoctrine()->getManager();
        // $repository = $em->getRepository('CoreBundle:User');
        //  var_dump($request->get('mail'));
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
        /* $mail_auth  =  $user->verifyMail($mail_user);
        $pass_auth = $user->verifyPassword($request->get('password'), $request->get('repeat_pass'));
        // echo $mail_auth . " xxx  " . $pass_auth;
        if ($mail_auth && $pass_auth) {
            $passwordEncoder = $this->get('security.password_encoder');
            return $passwordEncoder;
            //  $pass_enc = new passEncoder($mail_user, $request->get('password'));
            // $password_encoder = $user;
            //return $password_encoder;
            $user->setMail($mail_user);
            $user->setName($request->get('name'));
            $user->setSurname($request->get('surname'));
            $user->setPassword(sha1($request->get('password')));
            $user->setRole('0');
            // $em->persist($user);
            // $em->flush();
            // return   $this->redirectToRoute('login_page');
        } else {
            return $this->render('@Core/Default/Auth/register.html.twig', ['mail_err' => $mail_auth, 'pass_err' => $pass_auth]);
        }*/
    }
}
