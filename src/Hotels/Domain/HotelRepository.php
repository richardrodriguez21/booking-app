<?php

declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Hotels\Domain;

interface HotelRepository
{
    public function findById(HotelId $id): ?Hotel;
    public function save(Hotel $hotel): void;
}

