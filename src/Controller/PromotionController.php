<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Form\PromotionType;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


#[ROUTE('/api')]
class PromotionController extends AbstractController
{
    public function __construct(private PromotionRepository $promotionRepository)
    {
    }

    #[Route('/promotion', name: 'promotion_get_all', methods: ['GET'])]
    public function getAllPromotion(): Response
    {
        dd($this->promotionRepository->find(22));
        $promotions = $this->promotionRepository->findAll();
        dd($promotions);
        return $this->json($promotions, context: ['groups' => 'promotion_find_all']);
    }

    #[Route('/promotion/{id}', name: 'promotion_get_one', methods: ['GET'])]
    public function getOnePromotion($id): Response
    {
        $promotion = $this->promotionRepository->find($id);

        if (!$promotion instanceof  Promotion) {
            throw new NotFoundHttpException('Not found');
        }

        return $this->json($promotion, context: ['groups' => 'promotion_find_one']);
    }

    #[Route('/promotion', name: 'promotion_post', methods: ['POST'])]
    public function createPromotion(Request $request): Response
    {
        $promotion = new Promotion();

        $form = $this->createForm(PromotionType::class, $promotion);
        $form->submit(json_decode($request->getContent(), true));

        $this->promotionRepository->add($promotion);

        return $this->json($promotion);
    }

    #[Route('/promotion/{id}', name: 'promotion_put', methods: ['PUT'])]
    public function update($id, Request $request): Response
    {
        $promotion = $this->promotionRepository->find($id);

        if (!$promotion instanceof Promotion) {
            throw new NotFoundHttpException('Not found');
        }

        $form = $this->createForm(PromotionType::class, $promotion);
        $form->submit(json_decode($request->getContent(), true));

        $this->promotionRepository->add($promotion);

        return $this->json($promotion);
    }
}
