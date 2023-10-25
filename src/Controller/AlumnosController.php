<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlumnosController extends AbstractController
{
     /**
     * @Route("alumnos", name="alumnos")
     * 
     */

    public function listar(Request $request)
    {
        try{      
                
        $alumnox = $request->get('alumnox', 'San martin');

        if (empty($alumnox)) {
            throw new \Exception('Debe asignar un valor a la variable alumnox.');
        }
        $response = new JsonResponse();
        $response->setData([
            'success' => true,
            'data' => [
                [
                    'id' => 1,
                    'nombreyapellido' => 'Renata Miranda'
                ],
                [
                    'id' => 2,
                    'nombreyapellido' => 'Itati lind'
                ],
                [
                    'id' => 3,
                    'nombreyapellido' => $alumnox
                ]
            ]
                ]);
        return $response;

    } catch(\Exception $e) {
        return new JsonResponse([
            'success' => false,
            'message' => 'Se ha producido una excepcion: ' . $e->getMessage()
        ]);
    }
  }
}