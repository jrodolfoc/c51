<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use App\Utils\SortOffersFormatter;
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
        $sortFormatter = new SortOffersFormatter($sort, $direction);

        /** @var Offer[] $offers */
        $offers = $offerRepository->findBy([], [$sortFormatter->getSort() => $sortFormatter->getDirection()]);

        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
            'sort' => $sortFormatter->getSort(),
            'nameDirection' => $sortFormatter->calculateNextDirection('name'),
            'cashDirection' => $sortFormatter->calculateNextDirection('cash_back'),
        ]);
    }
}
