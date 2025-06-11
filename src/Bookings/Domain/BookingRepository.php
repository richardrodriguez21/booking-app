<?php

declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Bookings\Domain;

interface BookingRepository
{
    public function save(Booking $booking): void;
    public function findById(BookingId $id): ?Booking;
    public function findAll(): array;
}
