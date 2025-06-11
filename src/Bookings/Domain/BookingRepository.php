<?php

declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Bookings\Domain;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelId;

interface BookingRepository
{
    public function save(Booking $booking): void;
    public function findByHotel(HotelId $hotelId): ?Booking;
    public function findAll(): array;
}
