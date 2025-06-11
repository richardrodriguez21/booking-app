<?php

namespace Richardrodriguez21\BookingApp\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Richardrodriguez21\BookingApp\Bookings\Application\BookingCreator;
use Symfony\Component\HttpFoundation\Request;

class CreateBooking extends AbstractController
{
    public function __construct( private BookingCreator $bookingCreator )
    {
    }

    #[Route('/api/v1/bookings', name: 'api_v1_bookings_create', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $this->bookingCreator->execute($request->get('hotelId'), $request->get('email'), $request->get('name'), $request->get('lastName'), $request->get('roomsQty'));
        return $this->json(['message' => 'Booking created successfully']);
    }
}
