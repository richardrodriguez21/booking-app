<?php

namespace Richardrodriguez21\BookingApp\Hotels\Application;

use Richardrodriguez21\BookingApp\Hotels\Domain\HotelRepository;

class AllHotelsFinder
{
    public function __construct(private HotelRepository $hotelRepository)
    {
    }

    public function execute(): array
    {   
        return $this->hotelRepository->findAll();
    }
}