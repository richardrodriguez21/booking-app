<?php

namespace Richardrodriguez21\BookingApp\Hotels\Application;

use Richardrodriguez21\BookingApp\Bookings\Domain\BookingRepository;
use Richardrodriguez21\BookingApp\Hotels\Domain\Hotel;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelId;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelRepository;
use Richardrodriguez21\BookingApp\Hotels\Application\HotelFinderByIdResponse;

final class HotelFinderById
{
    public function __construct(private HotelRepository $hotelRepository, private BookingRepository $bookingRepository)
    {
    }

    public function execute(HotelId $hotelId): HotelFinderByIdResponse
    {
         $hotel = $this->hotelRepository->findById($hotelId);
         $bookedRoomsQty = $this->bookingRepository->findByHotel($hotelId);
         $availableRoomsQty = $hotel->getRoomsQty() - count($bookedRoomsQty);
         return  HotelFinderByIdResponse::fromDomain($hotel, $availableRoomsQty);
    }
}