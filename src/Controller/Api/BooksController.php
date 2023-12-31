<?php

namespace App\Controller\Api;

use App\Entity\Book;
use App\Form\Model\BookDto;
use App\Form\Type\BookFormType;
use Doctrine\ORM\EntityManager;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\Filesystem\Filesystem;
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
    public function PostActions(EntityManagerInterface $em, Request $request, FilesystemOperator $defaultStorage)
    {
        $bookDto= new BookDto();
        $form = $this->createForm(BookFormType::class, $bookDto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $extension = explode('/', mime_content_type($bookDto->base64Image))[1];
            $data = explode(',', $bookDto->base64Image );
            $filename = sprintf('%s.%s', uniqid('book_', true),$extension);


            $defaultStorage->write($filename, base64_decode($data[1]));
            $book = new Book();
            $book->setTitle($bookDto->title);
            $book->setImage($filename);
            $em->persist($book);
            $em->flush();
            return $book;
        }
        return $form;

    }










}