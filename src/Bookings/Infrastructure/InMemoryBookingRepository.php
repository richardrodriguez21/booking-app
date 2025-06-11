<?php

declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Bookings\Infrastructure;

use Richardrodriguez21\BookingApp\Bookings\Domain\Booking;
use Richardrodriguez21\BookingApp\Bookings\Domain\BookingId;
use Richardrodriguez21\BookingApp\Bookings\Domain\BookingRepository;
use Richardrodriguez21\BookingApp\Hotels\Infrastructure\InMemoryHotelRepository;
final class InMemoryBookingRepository implements BookingRepository
{
    private array $bookings = [];

    public function save(Booking $booking): void
    {
        $this->bookings[$booking->getId()->getValue()] = $booking;
    }

    public function findById(BookingId $id): ?Booking
    {
        return $this->bookings[$id->getValue()] ?? null;
    }

    public function findAll(): array
    {
        return $this->bookings;
    }


    private function build(): void
    {
       // load hotels from InMemoryHotelRepository and radomly generate 100 bookings in total
       $hotels = (new InMemoryHotelRepository())->findAll();
       foreach ($hotels as $hotel) {
        $this->bookings[] = new Booking( BookingId::generate(), $hotel->getId(), rand(1, 10), 'test@test.com', 'John', 'Doe');
       }
    }
    
}   