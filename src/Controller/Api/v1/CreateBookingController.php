<?php

namespace Richardrodriguez21\BookingApp\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Richardrodriguez21\BookingApp\Bookings\Application\BookingCreator;
use Symfony\Component\HttpFoundation\Request;


final class CreateBookingController extends AbstractController
{
    public function __construct( private BookingCreator $bookingCreator )
    {
    }

    #[Route('/api/v1/bookings', name: 'api_v1_bookings_create', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);
        $this->bookingCreator->execute($body['hotelId'], $body['email'], $body['name'], $body['lastName'], (int)$body['roomsQty']);
        return $this->json(['message' => 'Booking created successfully']);
    }
}
