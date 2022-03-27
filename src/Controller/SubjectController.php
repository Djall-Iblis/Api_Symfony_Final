<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Entity\SupportWorker;
use App\Form\SubjectType;
use App\Form\SupportWorkerType;
use App\Repository\SubjectRepository;
use App\Repository\SupportWorkerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


#[ROUTE('/api')]
class SubjectController extends AbstractController
{
    public function __construct(private SubjectRepository $subjectRepository)
    {
    }

    #[Route('/subject', name: 'subject_get_all', methods: ['GET'])]
    public function getAllSubject(): Response
    {
        $subject = $this->subjectRepository->findAll();

        return $this->json($subject, context: ['groups' => 'subject_find_all']);
    }

    #[Route('/subject/{id}', name: 'subject_get_one', methods: ['GET'])]
    public function getOneSubject($id): Response
    {
        $subject = $this->subjectRepository->find($id);

        if (!$subject instanceof  Subject) {
            throw new NotFoundHttpException('Not found');
        }

        return $this->json($subject, context: ['groups' => 'subject_find_one']);
    }

    #[Route('/subject', name: 'subject_post', methods: ['POST'])]
    public function createSubject(Request $request): Response
    {
        $subject = new Subject();

        $form = $this->createForm(SubjectType::class, $subject);
        $form->submit(json_decode($request->getContent(), true));

        $this->subjectRepository->add($subject);

        return $this->json($subject);
    }

    #[Route('/subject/{id}', name: 'subject_put', methods: ['PUT'])]
    public function updateSubject($id, Request $request): Response
    {
        $subject = $this->subjectRepository->find($id);

        if (!$subject instanceof Subject) {
            throw new NotFoundHttpException('Not found');
        }

        $form = $this->createForm(SubjectType::class, $subject);
        $form->submit(json_decode($request->getContent(), true));

        $this->subjectRepository->add($subject);

        return $this->json($subject);
    }
}
