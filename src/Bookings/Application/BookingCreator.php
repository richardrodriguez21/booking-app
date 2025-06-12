<?php

namespace Richardrodriguez21\BookingApp\Bookings\Application;
use Richardrodriguez21\BookingApp\Bookings\Domain\BookingRepository;
use Richardrodriguez21\BookingApp\Bookings\Domain\Booking;  
use Richardrodriguez21\BookingApp\Bookings\Domain\BookingId;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelId;
use Richardrodriguez21\BookingApp\Shared\ValueObject\Email;
final class BookingCreator
{
    public function __construct(private BookingRepository $bookingRepository)
    {}
    
    public function execute(string $hotelId, string $email, string $name, string $lastName, int $roomsQty): void
    {
        $booking = new Booking(
            BookingId::generate(),
            new HotelId($hotelId),
            $roomsQty,
            new Email($email),
            $name,
            $lastName
        );
        $this->bookingRepository->save($booking);
    }
}   
