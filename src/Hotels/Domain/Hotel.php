<?php
declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Hotels\Domain;

final class Hotel
{
    private HotelId $id;
    private string $name;
    private string $city;
    private string $country;
    private int $roomsQty;

    public function __construct(HotelId $id, string $name, string $city, string $country, int $roomsQty)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->country = $country;
        $this->roomsQty = $roomsQty;
    }

    public function getId(): HotelId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getRoomsQty(): int
    {
        return $this->roomsQty;
    }
    

}