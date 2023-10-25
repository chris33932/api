<?php
namespace App\Controller;
use App\Entity\Book;
use App\Repository\BookRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class LibraryController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("books", name="books_get")
     * 
     */
    public function list(Request $request, BookRepository $bookRepository){
            
        $books = $bookRepository->findAll();
        $booksAsArray = [];
        foreach ($books as $book) {
            $booksAsArray[]= [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'image' => $book->getImage()
            ];
        };
        $response = new JsonResponse();
        $response->setData([
            'success'=> true,
            'data' => $booksAsArray
        ]);
        return $response;

    }

    /**
     * @Route("/book/create", name="book_create")
     * 
     */
    public function createBook(Request $request, EntityManagerInterface $em)
    {
        $book = new Book();
        $response = new JsonResponse();
        $title = $request->get('title', null);
        if (empty($title)){
            $response->setData([
                'success' => false,
                'error' => 'Titulo no puede estar vacio',
                'data' => null
            ]);
            return $response;
        }
        $book->setTitle($title);
        $em->persist($book);
        $em->flush();
        $response->setData([
            'success' => true,
            'data' => [
                [
                    'id' => $book->getId(),
                    'title' => $book->getTitle()
                ]
            ]
                ]);
        return $response;
    }

}