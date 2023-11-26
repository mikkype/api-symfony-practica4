<?php

namespace App\Controller;

use App\Repository\ProfesorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Profesor;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use PhpParser\Node\Stmt\Return_;


class ProfesorController extends AbstractController
{

    private $registry;
    public function __construct(ManagerRegistry $registry)
    {
       $this->registry=$registry;
    }
    
    #[Route('/profesor', name: 'app_profesor')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProfesorController.php',
        ]);
    }

    /*metodo GET ALL */
    #[Route('/api/profesor', methods: ['GET'])]
    public function mostrarTodosProfesores(ProfesorRepository $profesorRepository): JsonResponse
    {
        $profesores = $profesorRepository->findAll();
        $data = [];
        foreach ($profesores as $profesor) {
            $data[] = [
                'id' => $profesor->getId(),
                'profesor_id' => $profesor->getProfesorId(),
                'nombre' => $profesor->getNombre(),
                'apellido' => $profesor->getApellido(),
                'fecha_nacimiento' => $profesor->getFechaNacimiento(),
                'direccion' => $profesor->getDireccion(),
                'telefono' => $profesor->getTelefono(),
                'codigo_postal' => $profesor->getCodigoPostal(),
                'email' => $profesor->getEmail(),
                'especialidad' => $profesor->getEspecialidad(),
            ];
        }

        $response = new JsonResponse();

        return $response->setData([
            'success' => true,
            'Tabla Profesor' => $data
        ]);
    }

    /*metodo GET*/
    #[Route('/api/profesor/{id}', methods: ['GET', 'HEAD'])]
    public function mostrarProfesorID(int $id, ProfesorRepository $profesorRepository): JsonResponse
    {
        $profesor = $profesorRepository->find($id);
        if (!$profesor) {
            return new JsonResponse(['success' => false, 'error' => 'Profesor no encontrado'], 404);
        }

        $response = new JsonResponse();
        $response->setData([
            'success' => true,
            'data' =>
            [
                [
                    'id' => $profesor->getId(),
                    'estudiante_id' => $profesor->getProfesorId(),
                    'nombre' => $profesor->getNombre(),
                    'apellido' => $profesor->getApellido(),
                    'fecha_nacimiento' => $profesor->getFechaNacimiento(),
                    'direccion' => $profesor->getDireccion(),
                    'telefono' => $profesor->getTelefono(),
                    'codigo_postal' => $profesor->getCodigoPostal(),
                    'email' => $profesor->getEmail(),
                    'especialidad' => $profesor->getEspecialidad(),
                ]
            ]
        ]);
      
        return $response;
    }

    /*metodo POST*/
    #[Route('/api/profesor', methods: ['POST'])]
    public function insertarProfesor(Request $request, ManagerRegistry $registry): JsonResponse
    {
        $em = $registry->getManager();
        $profesor = new Profesor;
        $response = new JsonResponse();

        $Data = json_decode($request->getContent(), true);

        $profesor->setProfesorId($Data['profesor_id']);
        $profesor->setNombre($Data['nombre']);
        $profesor->setApellido($Data['apellido']);
        $profesor->setFechaNacimiento(new \DateTime($Data['fecha_nacimiento']));
        $profesor->setDireccion($Data['direccion']);
        $profesor->setTelefono($Data['telefono']);
        $profesor->setCodigoPostal($Data['codigo_postal']);
        $profesor->setEmail($Data['email']);
        $profesor->setEspecialidad($Data['especialidad']);

        $em->persist($profesor);
        $em->flush();

        return $response->setData(['Estado :' => 'Nuevo PROFESOR creado']);
    }

     /*metodo update*/
     #[Route('/api/profesor/{id}', methods: ['PUT'])]
     public function actualizarProfesor(int $id, Request $request, ManagerRegistry $registry): JsonResponse
     {
         $em = $registry->getManager();
         $profesor = $em->getRepository(Profesor::class)->find($id);
         if (!$profesor) {
             return new JsonResponse(['success' => false, 'error' => 'Profesor no encontrado'], 404);
         }
 
         $response = new JsonResponse();
 
         $Data = json_decode($request->getContent(), true);
 
         $profesor->setProfesorID($Data['profesor_id']);
         $profesor->setNombre($Data['nombre']);
         $profesor->setApellido($Data['apellido']);
         $profesor->setFechaNacimiento(new \DateTime($Data['fecha_nacimiento']));
         $profesor->setDireccion($Data['direccion']);
         $profesor->setTelefono($Data['telefono']);
         $profesor->setCodigoPostal($Data['codigo_postal']);
         $profesor->setEmail($Data['email']);
         $profesor->setEspecialidad($Data['especialidad']);
 
         $em->flush();
 
         return $response->setData(['Estado :' => 'Profesor actualizado']);
     }

      /*metodo delete*/
    #[Route('/api/profesor/{id}', methods: ['DELETE'])]
    public function borrarProfesor(int $id, ManagerRegistry $registry): JsonResponse
    {
        $em = $registry->getManager();
        $profesor = $em->getRepository(Profesor::class)->find($id);
        if (!$profesor) {
            return new JsonResponse(['success' => false, 'error' => 'Profesor no encontrado'], 404);
        }

        $response = new JsonResponse();

        $em->remove($profesor);
        $em->flush();

        return $response->setData(['Estado :' => 'Profesor eliminado con ID']);
    }
}
