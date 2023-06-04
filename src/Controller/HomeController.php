<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Category;
use App\Entity\Price;
use App\Entity\Product;
use App\Service\BlogService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/create", name="create-blog")
     * @param Request $request
     * @param BlogService $blogService
     * @param EntityManagerInterface $em
     * @return mixed
     */
    public function create(Request $request, BlogService $blogService, EntityManagerInterface $em)
    {
        $category = $em->getRepository(Category::class)->findAll();
        $product = $em->getRepository(Product::class)->findAll();
        $price = $em->getRepository(Price::class)->findAll();

        if ($request->isMethod('POST')) {
            $blogService->create($request);

            return $this->redirectToRoute("create-blog");
        }

        return $this->render("home/create.html.twig", [
            "category" => $category,
            "product" => $product,
            "price" => $price
        ]);
    }

    /**
     * @Route("/update-blog/{id}", name="updated-blog")
     * @param Request $request
     * @param $id
     * @param EntityManagerInterface $em
     * @param BlogService $blogService
     * @return RedirectResponse|Response
     */
    public function update(
        Request $request,
        $id,
        EntityManagerInterface $em,
        BlogService $blogService
        )
    {
        $blog = $em->getRepository(Blog::class)->find($id);
        $category = $em->getRepository(Category::class)->findAll();
        $product = $em->getRepository(Product::class)->findAll();
        $price = $em->getRepository(Price::class)->findAll();

        if ($request->isMethod('POST')) {
            $blogService->update($request,$id);

            return $this->redirectToRoute("updated-blog");
        }
            return $this->render("home/update.html.twig", [
                "blog" => $blog,
                "category" => $category,
                "product" => $product,
                "price" => $price
            ]);

    }



}
