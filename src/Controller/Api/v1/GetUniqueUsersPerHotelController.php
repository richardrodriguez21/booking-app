<?php

namespace Richardrodriguez21\BookingApp\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Richardrodriguez21\BookingApp\Bookings\Application\UniqueUsersPerHotelFinder;

final class GetUniqueUsersPerHotelController extends AbstractController
{
    public function __construct(private UniqueUsersPerHotelFinder $uniqueUsersPerHotelFinder)
    {
    }

    #[Route('/api/v1/statistics/unique-users-per-hotel', name: 'api_v1_hotels_unique_users', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $data = $this->uniqueUsersPerHotelFinder->execute();
        return $this->json(['data' => $data]);
    }
}
