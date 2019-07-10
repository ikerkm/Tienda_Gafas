<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Category;
use CoreBundle\Entity\Glasses;
use CoreBundle\Form\ProductType;

class AdminController extends Controller
{

    /**
     * @Route("/admin_panel")
     */
    public function adminPanel()
    {


        $user = $this->getUser();

        $surname = $this->get('session')->get('surname');
        $user_name = $user->getName() . " " . $user->getSurname();
        return $this->render('@Core/Default/Admin/admin_panel.html.twig');
    }
    /**
     * @Route("/admin_panel/newproduct")
     */
    public function newProduct(Request $request)
    {

        $category_selector = $this->getDoctrine()->getRepository(Category::class);
        $category = $category_selector->findAll();

        /* array(

            'category' => $category,
        )*/
        $glasses = new Glasses();
        $form = $this->createForm(ProductType::class, array(
            'glasses' => $glasses,
            'category' => $category,
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // $em->persist($category);
            //  $em->flush();

            //return $this->redirectToRoute('register_page', array('id' => $user->getId()));
        }
        return $this->render('@Core/Default/Admin/addproduct.html.twig', array(

            'form' => $form->createView(),
        ));
    }
}
