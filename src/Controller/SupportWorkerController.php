<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Entity\SupportWorker;
use App\Form\PromotionType;
use App\Form\SupportWorkerType;
use App\Repository\PromotionRepository;
use App\Repository\SupportWorkerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[ROUTE('/api')]
class SupportWorkerController extends AbstractController
{
    public function __construct(private SupportWorkerRepository $supportWorkerRepository)
    {
    }

    #[Route('/supportWorker', name: 'SW_get_all', methods: ['GET'])]
    public function getAllSW(): Response
    {
        $supportWorker = $this->supportWorkerRepository->findAll();

        return $this->json($supportWorker, context: ['groups' => 'SW_find_all']);
    }

    #[Route('/supportWorker/{id}', name: 'SW_get_one', methods: ['GET'])]
    public function getOneSW($id): Response
    {
        $supportWorker = $this->supportWorkerRepository->find($id);

        if (!$supportWorker instanceof  SupportWorker) {
            throw new NotFoundHttpException('Not found');
        }

        return $this->json($supportWorker, context: ['groups' => 'SW_find_one']);
    }

    #[Route('/supportWorker', name: 'SW_post', methods: ['POST'])]
    public function createPromotion(Request $request): Response
    {
        $supportWorker = new SupportWorker();

        $form = $this->createForm(SupportWorkerType::class, $supportWorker);
        $form->submit(json_decode($request->getContent(), true));

        $this->supportWorkerRepository->add($supportWorker);

        return $this->json($supportWorker);
    }

    #[Route('/supportWorker/{id}', name: 'SW_put', methods: ['PUT'])]
    public function update($id, Request $request): Response
    {
        $supportWorker = $this->supportWorkerRepository->find($id);

        if (!$supportWorker instanceof SupportWorker) {
            throw new NotFoundHttpException('Not found');
        }

        $form = $this->createForm(SupportWorkerType::class, $supportWorker);
        $form->submit(json_decode($request->getContent(), true));

        $this->supportWorkerRepository->add($supportWorker);

        return $this->json($supportWorker);
    }
}
