<?php

namespace Richardrodriguez21\BookingApp\Bookings\Application;
use Richardrodriguez21\BookingApp\Bookings\Domain\BookingRepository;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelRepository;

final class UniqueUsersPerHotelFinder
{
    public function __construct(
        private BookingRepository $bookingRepository,
        private HotelRepository $hotelRepository
    )
    {
    }

    public function execute(): array
    {
        $hotels = $this->hotelRepository->findAll();
        foreach ($hotels as $hotel) {
            $bookings = $this->bookingRepository->findByHotel($hotel->getId());
            $users = array_map(function($booking) {
                return $booking->getEmail();
            }, $bookings);
            $uniqueUsers = array_unique($users, SORT_REGULAR);
            $data[] = [
                'id' => $hotel->getId()->getValue(),
                'users' => count($uniqueUsers),
            ];
        }
        return $data;
    }
}