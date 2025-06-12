<?php

namespace Richardrodriguez21\BookingApp\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Richardrodriguez21\BookingApp\Bookings\Domain\BookingRepository;   
use Symfony\Component\Routing\Annotation\Route;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelRepository;

final class GetUniqueUsersPerHotelController extends AbstractController
{
    public function __construct(private HotelRepository $hotelRepository, private BookingRepository $bookingRepository)
    {
    }

    #[Route('/api/v1/statistics/unique-users-per-hotel', name: 'api_v1_hotels_unique_users', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $hotels = $this->hotelRepository->findAll();
        foreach ($hotels as $hotel) {
            $bookings = $this->bookingRepository->findByHotel($hotel->getId());
            $uniqueUsers = array_unique($bookings, SORT_REGULAR);
            $data[] = [
                'id' => $hotel->getId()->getValue(),
                'users' => count($uniqueUsers),
            ];
        }
        return $this->json(['data' => $data]);
    }
}
