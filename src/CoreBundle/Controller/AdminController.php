<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Category;
use CoreBundle\Entity\Glasses;
use CoreBundle\Form\ProductType;

class AdminController extends Controller
{

    /**
     * @Route("/admin_panel", name="admin_panel")
     */
    public function adminPanel()
    {


        $user = $this->getUser();

        $repository_glasses = $this->getDoctrine()->getRepository(Glasses::class);
        $glasses = $repository_glasses->findAll();
        return $this->render('@Core/Default/Admin/admin_panel.html.twig', ['glasses' => $glasses]);
    }
    /**
     * @Route("/admin_panel/newproduct",  name="newproduct_page")
     */
    public function newProduct(Request $request)
    {

        $category_selector = $this->getDoctrine()->getRepository(Category::class);
        $category = $category_selector->findAll();


        $glasses = new Glasses();

        $form = $this->createForm(ProductType::class, $glasses, array(

            'category' => $category,
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {




            $imageFile = $form['imgRoute']->getData();


            if ($imageFile) {

                $newFilename =  uniqid() . '.' . $imageFile->guessExtension();

                $glasses->setimgRoute("imageGlasses/" . $newFilename);

                $em = $this->getDoctrine()->getManager();

                $em->persist($glasses);
                $em->flush();

                try {
                    $imageFile->move(
                        $this->getParameter('imageGlasses_directory'),
                        $newFilename
                    );
                } catch (FileException $e) { }
            }


            return $this->redirectToRoute('admin_panel');
        }


        return $this->render('@Core/Default/Admin/addproduct.html.twig', array(

            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin_panel/editproduct/{id}",  name="editproduct_page")
     */
    public function editProduct(Request $request, Glasses $glasses)
    {
        $id = $request->attributes->get('id');

        $repository_glasses = $this->getDoctrine()->getRepository(Glasses::class);
        $glass = $repository_glasses->findById($id);
        $category_selector = $this->getDoctrine()->getRepository(Category::class);
        $category = $category_selector->findAll();

        $form = $this->createForm(ProductType::class, $glasses, array(

            'category' => $category,
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {




            $imageFile = $form['imgRoute']->getData();

            if ($imageFile) {



                $newFilename =  uniqid() . '.' . $imageFile->guessExtension();


                $glasses->setimgRoute("imageGlasses/" . $newFilename);

                $this->getDoctrine()->getManager()->flush();


                try {
                    $imageFile->move(
                        $this->getParameter('imageGlasses_directory'),
                        $newFilename
                    );
                } catch (FileException $e) { }
            }


            return $this->redirectToRoute('admin_panel');
        }


        return $this->render('@Core/Default/Admin/editproduct.html.twig', array(
            'glass' => $glass,
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/admin_panel/deleteproduct/{id}",  name="deleteproduct_page")
     */
    public function deleteProduct(Request $request)
    {
        $id = $request->attributes->get('id');

        $repository_glasses = $this->getDoctrine()->getRepository(Glasses::class);
        $glass = $repository_glasses->findById($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($glass[0]);
        $em->flush();
        return $this->redirectToRoute('admin_panel');
    }
}
