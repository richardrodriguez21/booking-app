<?php

namespace Richardrodriguez21\BookingApp\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Richardrodriguez21\BookingApp\Hotels\Application\AllHotelsFinder;
use Symfony\Component\Routing\Annotation\Route;

final class GetAllHotelsController extends AbstractController
{

    public function __construct(private AllHotelsFinder $allHotelsFinder)
    {}

    #[Route('/api/v1/hotels', name: 'api_v1_hotels_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $hotels = $this->allHotelsFinder->execute();
        $data = [];
        foreach ($hotels as $hotel) {
            $data[] = [
                'id' => $hotel->getId()->getValue(),
                'name' => $hotel->getName(),
            ];
        }
        return $this->json($data);
    }
}