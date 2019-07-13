<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Glasses;
use CoreBundle\Entity\Category;
use CoreBundle\Entity\Sex;

class ShopController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function showMain()
    {
        $repository_gender = $this->getDoctrine()->getRepository(Sex::class);
        $gender = $repository_gender->findAll();
        $repository_category =  $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository_category->findAll();
        $repository_glasses = $this->getDoctrine()->getRepository(Glasses::class);
        $glasses = $repository_glasses->findAll();
        $user = $this->getUser();
        $role = $user->getRoles();
        dump($role[0]);
        if ($user) {
            $user_name = $user->getName() . " " . $user->getSurname();
        } else {
            $user_name = "Guest";
        }
        return $this->render('@Core/Default/Shop/home.html.twig', ['role' => $role, 'user_name' => $user_name, 'glasses' => $glasses, 'categories' => $categories, 'gender' => $gender]);
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
        $role = $user->getRoles();
        if ($user) {
            $user_name = $user->getName() . " " . $user->getSurname();
        } else {
            $user_name = "Guest";
        }
        return $this->render('@Core/Default/Shop/glass.html.twig', ['role' => $role, 'glass_desc' => $glasses, 'user_name' => $user_name]);
    }

    /**
     * @Route("/category/{id}", name="product_category")
     */
    public function showCateogry(Request $request)
    {
        $category_id = $request->attributes->get('id');
        dump($category_id);
        $repository_gender = $this->getDoctrine()->getRepository(Sex::class);
        $gender = $repository_gender->findAll();
        $repository_category =  $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository_category->findAll();
        $category_selected = $repository_category->findById($category_id);
        $repository_glasses = $this->getDoctrine()->getRepository(Glasses::class);
        $glasses = $repository_glasses->findByCategory($category_id);
        $user = $this->getUser();
        $role = $user->getRoles();
        if ($user) {
            $user_name = $user->getName() . " " . $user->getSurname();
        } else {
            $user_name = "Guest";
        }
        return $this->render('@Core/Default/Shop/category.html.twig', ['role' => $role, 'user_name' => $user_name, 'glasses' => $glasses, 'categories' => $categories, 'gender' => $gender, 'current_category' => $category_selected, 'current_gender' => 0]);
    }


    /**
     * @Route("/gender/{id}", name="product_gender")
     */
    public function showGender(Request $request)
    {
        $gender_id = $request->attributes->get('id');
        $repository_gender = $this->getDoctrine()->getRepository(Sex::class);
        $current_gender = $repository_gender->findById($gender_id);
        $gender = $repository_gender->findAll();
        $repository_category =  $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository_category->findAll();
        $repository_glasses = $this->getDoctrine()->getRepository(Glasses::class);
        $glasses = $repository_glasses->findBySex($gender_id);
        $user = $this->getUser();
        $role = $user->getRoles();
        if ($user) {
            $user_name = $user->getName() . " " . $user->getSurname();
        } else {
            $user_name = "Guest";
        }
        return $this->render('@Core/Default/Shop/category.html.twig', ['role' => $role, 'user_name' => $user_name, 'glasses' => $glasses, 'categories' => $categories, 'gender' => $gender, 'current_gender' => $current_gender, 'current_category' => 0]);
    }
}
