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
     * @Route("/", methods="GET", name="offer_index")
     * @param OfferRepository $offerRepository
     * @return Response
     */
    public function index(OfferRepository $offerRepository): Response
    {
        /** @var Offer[] $offers */
        $offers = $offerRepository->findAll();

        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
        ]);
    }
}
