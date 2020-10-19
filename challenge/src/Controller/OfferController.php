<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to display offers
 *
 * @Route("/offer")
 *
 * @author Jose Calvo <jrodolfoc@gmail.com>
 */
class OfferController extends AbstractController
{
    /**
     * Display all offers
     * @Route("/{sort}/{direction}", defaults={"sort": "name", "direction"="asc"}, methods="GET", name="offer_index")
     * @param OfferRepository $offerRepository
     * @param string $sort
     * @param string $direction
     * @return Response
     */
    public function index(OfferRepository $offerRepository, string $sort, string $direction): Response
    {
        if (!in_array(strtolower($sort), ['name', 'cash_back'])) {
            $sort = 'name';
        }

        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'asc';
        }

        /** @var Offer[] $offers */
        $offers = $offerRepository->findBy([], [$sort => $direction]);

        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
            'sort' => $sort,
            'nameDirection' => $this->calculateNextDirection('name', $sort, $direction),
            'cashDirection' => $this->calculateNextDirection('cash_back', $sort, $direction),
        ]);
    }

    /**
     * @param $column
     * @param $currentSort
     * @param $currentDirection
     * @return string
     */
    private function calculateNextDirection($column, $currentSort, $currentDirection)
    {
        if ($column != $currentSort) {
            return 'asc';
        }

        return $currentDirection == 'asc' ? 'desc' : 'asc';
    }
}
