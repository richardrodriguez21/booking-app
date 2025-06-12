<?php

namespace Richardrodriguez21\BookingApp\Hotels\Application;
use Richardrodriguez21\BookingApp\Hotels\Domain\Hotel;

final class HotelFinderByIdResponse
{  

    public function __construct(
        public readonly string  $id, 
        public readonly string $name, 
        public readonly string $city, 
        public readonly string $country, 
        public readonly int $roomsQty,
        public readonly int $availableRoomsQty
    ) {}

    public static function fromDomain(Hotel $hotel, int $availableRoomsQty): self
    {
        return new self(
            $hotel->getId(),
            $hotel->getName(),
            $hotel->getCity(),
            $hotel->getCountry(),
            $hotel->getRoomsQty(),
            $availableRoomsQty
        );
    }
}