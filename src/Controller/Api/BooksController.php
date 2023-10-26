<?php

namespace App\Controller\Api;

use App\Entity\Book;
use Doctrine\ORM\EntityManager;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;



class BooksController extends AbstractFOSRestController
{
    /**
    * @Rest\Get(path="/books")
    * @Rest\View(serializerGroups={"book"},serializerEnableMaxDepthChecks=true)
    */
    public function getActions(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();
        
        return $books;

    }


    /**
    * @Rest\Post(path="/books")
    * @Rest\View(serializerGroups={"book"},serializerEnableMaxDepthChecks=true)
    */
    public function PostActions(EntityManagerInterface $em)
    {
        $book= new Book();
        $book->setTitle('El libro de la vida');
        $em->persist($book);
        $em->flush();

        return $book;

    }










}