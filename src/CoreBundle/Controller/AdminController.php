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
     * @Route("/admin_panel/newproduct",  name="newproduct_page")
     */
    public function newProduct(Request $request)
    {

        $category_selector = $this->getDoctrine()->getRepository(Category::class);
        $category = $category_selector->findAll();

        /* array(

            'category' => $category,
        )*/
        $glasses = new Glasses();
        /* $form = $this->createForm(ProductType::class, array(
            'glasses' => $glasses,
            'category' => $category,
        ));*/
        $form = $this->createForm(ProductType::class, $glasses, array(

            'category' => $category,
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {



            // $em->persist($category);
            //  $em->flush();
            $imageFile = $form['imgRoute']->getData();
            dump($form['productName']->getData());
            //$glasses->setProductName($form['productName']->getData());
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {

                // this is needed to safely include the file name as part of the URL

                $newFilename =  uniqid() . '.' . $imageFile->guessExtension();


                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $glasses->setimgRoute("imageGlasses/" . $newFilename);

                $em = $this->getDoctrine()->getManager();

                $em->persist($glasses);
                $em->flush();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('imageGlasses_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }


            //return $this->redirectToRoute('register_page', array('id' => $user->getId()));
        }


        return $this->render('@Core/Default/Admin/addproduct.html.twig', array(

            'form' => $form->createView(),
        ));
    }
}
