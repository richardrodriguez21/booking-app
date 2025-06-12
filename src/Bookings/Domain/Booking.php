<?php

declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Bookings\Domain;

use Richardrodriguez21\BookingApp\Bookings\Domain\BookingId;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelId;
use Richardrodriguez21\BookingApp\Shared\ValueObject\Email;


final class Booking
{
    private BookingId $id;
    private HotelId $hotelId;
    private int $roomsQty;
    private Email $email;
    private string $name;
    private string $lastName;

    public function __construct(BookingId $id, HotelId $hotelId, int $roomsQty, Email $email, string $name, string $lastName)
    {
        $this->id = $id;
        $this->hotelId = $hotelId;
        $this->roomsQty = $roomsQty;
        $this->email = $email;
        $this->name = $name;
        $this->lastName = $lastName;
    }

    public function getId(): BookingId
    {
        return $this->id;
    }

    public function getHotelId(): HotelId
    {
        return $this->hotelId;
    }

    public function getRoomsQty(): int
    {
        return $this->roomsQty;
    }

    public function getEmail(): Email  
    {
        return $this->email;
    }

    public function getName(): string       
    {
        return $this->name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
    
    
}