<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


#[ROUTE('/api')]
class StudentController extends AbstractController
{
    public function __construct(private StudentRepository $studentRepository)
    {
    }

    #[Route('/student', name: 'student_index', methods: ['GET'])]
    public function index(): Response
    {
        $students = $this->studentRepository->findAll();

        return $this->json($students, context: ['groups' => 'student_find_all']);
    }

    #[Route('/student/{id}', name: 'student_get', methods: ['GET'])]
    public function show($id): Response
    {
        $student = $this->studentRepository->find($id);

        if (!$student instanceof Student) {
            throw new NotFoundHttpException('Not found');
        }

        return $this->json($student, context: ['groups' => 'student_find_one']);
    }

    #[Route('/student', name: 'student_post', methods: ['POST'])]
    public function createStudent(Request $request): Response
    {
        $student= new Student();

        $form = $this->createForm(StudentType::class, $student);
        $form->submit(json_decode($request->getContent(), true));

        $this->studentRepository->add($student);

        return $this->json($student, context: ['groups' => 'student_post']);
    }

    #[Route('/student/{id}', name: 'student_put', methods: ['PUT'])]
    public function update($id, Request $request): Response
    {
        $student = $this->studentRepository->find($id);

        if (!$student instanceof Student) {
            throw new NotFoundHttpException('Not found');
        }

        $form = $this->createForm(StudentType::class, $student);
        $form->submit(json_decode($request->getContent(), true));

        $this->studentRepository->add($student);

        return $this->json($student, context: ['groups' => 'student_put']);
    }

    #[Route('/student/{id}', name: 'student_delete', methods: ['DELETE'])]
    public function delete($id): Response
    {
        $student = $this->studentRepository->find($id);

        if (!$student instanceof Student) {
            throw new NotFoundHttpException('Not found');
        }

        $this->studentRepository->remove($student);

        return $this->json(true);
    }
}
