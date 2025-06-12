<?php
declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Controller\Api\v1;

use Richardrodriguez21\BookingApp\Hotels\Application\HotelFinderById;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class GetHotelController extends AbstractController
{
    public function __construct(private HotelFinderById $hotelFinderById)
    {}

    #[Route('/api/v1/hotels/{id}', name: 'api_v1_hotels_get', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $hotel = $this->hotelFinderById->execute(new HotelId($request->get('id')));
        return $this->json($hotel);
    }
}