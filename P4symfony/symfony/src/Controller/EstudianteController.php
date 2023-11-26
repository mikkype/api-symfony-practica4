<?php

namespace App\Controller;

use App\Repository\EstudianteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Estudiante;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\HttpFoundation\Request;

class EstudianteController extends AbstractController
{
    private $registry;
    public function __construct(ManagerRegistry $registry)
    {
       $this->registry=$registry;
    }

    #[Route('/estudiante', name: 'app_estudiante')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/EstudianteController.php',
        ]);
    }

    /*metodo GET ALL */
    #[Route('/api/estudiante', methods: ['GET'])]
    public function mostrarTodosEstudiantes(EstudianteRepository $estudianteRepository): JsonResponse
    {
        $estudiantes = $estudianteRepository->findAll();
        $data = [];
        foreach ($estudiantes as $estudiante) {
            $data[] = [
                'id' => $estudiante->getId(),
                'estudiante_id' => $estudiante->getEstudianteId(),
                'nombre' => $estudiante->getNombre(),
                'apellido' => $estudiante->getApellido(),
                'fecha_nacimiento' => $estudiante->getFechaNacimiento(),
                'direccion' => $estudiante->getDireccion(),
                'telefono' => $estudiante->getTelefono(),
                'codigo_postal' => $estudiante->getCodigoPostal(),
                'email' => $estudiante->getEmail(),

            ];
        }
        
        $response = new JsonResponse();

        return $response->setData([
            'success' => true,
            'Tabla Estudiante' => $data
        ]);
    }

    /*metodo GET*/
    #[Route('/api/estudiante/{id}', methods: ['GET', 'HEAD'])]
    public function mostrarEstudianteID(int $id, EstudianteRepository $estudianteRepository): JsonResponse
    {
        $estudiante = $estudianteRepository->find($id);
        if (!$estudiante) {
            return new JsonResponse(['success' => false, 'error' => 'Estudiante no encontrado'], 404);
        }

        $response = new JsonResponse();
        $response->setData([
            'success' => true,
            'data' =>
            [
                [
                    'id' => $estudiante->getId(),
                    'estudiante_id' => $estudiante->getEstudianteId(),
                    'nombre' => $estudiante->getNombre(),
                    'apellido' => $estudiante->getApellido(),
                    'fecha_nacimiento' => $estudiante->getFechaNacimiento(),
                    'direccion' => $estudiante->getDireccion(),
                    'telefono' => $estudiante->getTelefono(),
                    'codigo_postal' => $estudiante->getCodigoPostal(),
                    'email' => $estudiante->getEmail(),
                ]
            ]
        ]);
      
        return $response;
    }


    /*metodo POST*/
    #[Route('/api/estudiante/', methods: ['POST'])]
    public function insertarEstudiante(Request $request, ManagerRegistry $registry): JsonResponse
    {
        $em = $registry->getManager();
        $estudiante = new Estudiante;
        $response = new JsonResponse();

        $Data = json_decode($request->getContent(), true);

        $estudiante->setEstudianteId($Data['estudiante_id']);
        $estudiante->setNombre($Data['nombre']);
        $estudiante->setApellido($Data['apellido']);
        $estudiante->setFechaNacimiento(new \DateTime($Data['fecha_nacimiento']));
        $estudiante->setDireccion($Data['direccion']);
        $estudiante->setTelefono($Data['telefono']);
        $estudiante->setCodigoPostal($Data['codigo_postal']);
        $estudiante->setEmail($Data['email']);

        $em->persist($estudiante);
        $em->flush();

        return $response->setData(['Estado :' => 'Nuevo estudiante creado']);
    }

    /*metodo update*/
    #[Route('/api/estudiante/{id}', methods: ['PUT'])]
    public function actualizarEstudiante(int $id, Request $request, ManagerRegistry $registry): JsonResponse
    {
        $em = $registry->getManager();
        $estudiante = $em->getRepository(Estudiante::class)->find($id);
        if (!$estudiante) {
            return new JsonResponse(['success' => false, 'error' => 'Estudiante no encontrado'], 404);
        }

        $response = new JsonResponse();

        $Data = json_decode($request->getContent(), true);

        $estudiante->setEstudianteId($Data['estudiante_id']);
        $estudiante->setNombre($Data['nombre']);
        $estudiante->setApellido($Data['apellido']);
        $estudiante->setFechaNacimiento(new \DateTime($Data['fecha_nacimiento']));
        $estudiante->setDireccion($Data['direccion']);
        $estudiante->setTelefono($Data['telefono']);
        $estudiante->setCodigoPostal($Data['codigo_postal']);
        $estudiante->setEmail($Data['email']);

        $em->flush();

        return $response->setData(['Estado :' => 'Estudiante actualizado']);
    }

    /*metodo delete*/
    #[Route('/api/estudiante/{id}', methods: ['DELETE'])]
    public function borrarEstudiante(int $id, ManagerRegistry $registry): JsonResponse
    {
        $em = $registry->getManager();
        $estudiante = $em->getRepository(Estudiante::class)->find($id);
        if (!$estudiante) {
            return new JsonResponse(['success' => false, 'error' => 'Estudiante no encontrado'], 404);
        }

        $response = new JsonResponse();

        $em->remove($estudiante);
        $em->flush();

        return $response->setData(['Estado :' => 'Estudiante eliminado con ID']);
    }
}
