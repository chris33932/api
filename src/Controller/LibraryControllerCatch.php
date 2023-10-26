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

class LibraryControllerCatch extends AbstractController
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
       
        $response = new JsonResponse();
        
        try{
            $title = $request->get('title', null);
            if (empty($title)){
                throw new \Exception('Titulo no puede estar vacio');
            }
        $book = new Book();        
        $book->setTitle($title);
        $em->persist($book);
        $em->flush();
        $responseData = [
            'success' => true,
            'data' => [
                'id' => $book->getId(),
                'title' => $book->getTitle()
            ]
            ];

        $response->setData($responseData);
      
    }catch(\Exception $e){
        return new JsonResponse([
            'success' => false,
            'message' => 'Se ha producido una excepcion: '. $e->getMessage()
        ]);
    }
    return $response;
    } 
}