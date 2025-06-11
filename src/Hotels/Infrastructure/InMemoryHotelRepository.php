<?php

declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Hotels\Infrastructure;
use Richardrodriguez21\BookingApp\Hotels\Domain\Hotel;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelId;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelRepository;


final class InMemoryHotelRepository implements HotelRepository
{
    private array $hotels = [];

    public function __construct()
    {
        $this->build();
    }

    public function findById(HotelId $id): ?Hotel
    {
        return $this->hotels[$id->getValue()] ?? null;
    }

    public function save(Hotel $hotel): void
    {
        $this->hotels[$hotel->getId()->getValue()] = $hotel;
    }

    public function findAll(): array
    {
        return array_values($this->hotels);
    }

    private function build(): void
    { 
        $this->hotels = [
            new Hotel(new HotelId('01JXGEVEACMHJQ2X45GS31R0W7'), 'West Chandler Hotel', 'Chandler', 'Arizona', 10),
            new Hotel(new HotelId('01JXGEVEAF1XWV4ARKD0DERFCC'), 'Aureliaport Hotel', 'Aurelia', 'California', 10),
            new Hotel(new HotelId('01JXGEVEAKZDTDQ9WP4K6TVM3H'), 'Wizatown Hotel', 'Wiza', 'Texas', 10),
            new Hotel(new HotelId('01JXGEVEAMMSA01439PNN3CW81'), 'North Leta Hotel', 'Leta', 'North Carolina', 10),
            new Hotel(new HotelId('01JXGEVEAQGJYYYNR2D9KGH9TZ'), 'Jaysonville Hotel', 'Jayson', 'Texas', 10),   
            new Hotel(new HotelId('01JXGEVEASJ5RD1TED0XYYV7TF'), 'New Oswaldo Hotel', 'Oswaldo', 'Texas', 10),
            new Hotel(new HotelId('01JXGEVEAVAB2N56SBX9RNNC6C'), 'East Tyrique Hotel', 'Tyrique', 'Texas', 10),
            new Hotel(new HotelId('01JXGEVEAVAB2N56SBX9RNNC6D'), 'Port Arianeside Hotel', 'Arianeside', 'Texas', 10),
            new Hotel(new HotelId('01JXGEVEAZK4GEF2N7Z1R71ANM'), 'Nicholeport Hotel', 'Nichole', 'Texas', 10),
            new Hotel(new HotelId('01JXGEVEB0CQMZXJFTD2P4BQVJ'), 'Sigurdfort Hotel', 'Sigurd', 'Texas', 10),
        ];
    }
}