<?php

namespace App\Service;

use App\Entity\Blog;
use App\Entity\Category;
use App\Entity\Price;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class BlogService
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Request $request)
    {
        $blog = new Blog();
        $blog->setTitle($request->request->get('title'));
        $blog->setCategory($this->em->getRepository(Category::class)->find($request->request->get('category')));
        $blog->setProduct($this->em->getRepository(Product::class)->find($request->request->get('product')));
        $blog->setPrice($this->em->getRepository(Price::class)->find($request->request->get('price')));

        $this->em->persist($blog);
        $this->em->flush();

        return $blog;

    }

    public function update($id, Request $request)
    {
        /** @var Blog $blog */
        $blog = $this->em->getRepository(Blog::class)->findOneBy(['id' => $id]);
        $blog->setTitle($request->request->get('title'));
        $blog->setCategory($this->em->getRepository(Category::class)->find($request->request->get('category')));
        $blog->setProduct($this->em->getRepository(Product::class)->find($request->request->get('product')));
        $blog->setPrice($this->em->getRepository(Price::class)->find($request->request->get('price')));

        $this->em->persist($blog);
        $this->em->flush();

    }






}