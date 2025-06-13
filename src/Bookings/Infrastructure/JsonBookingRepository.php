<?php
//implement a json booking repository

declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Bookings\Infrastructure;

use Richardrodriguez21\BookingApp\Bookings\Domain\Booking;
use Richardrodriguez21\BookingApp\Bookings\Domain\BookingId;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelId;
use Richardrodriguez21\BookingApp\Hotels\Infrastructure\InMemoryHotelRepository;
use Richardrodriguez21\BookingApp\Bookings\Domain\BookingRepository;
use Richardrodriguez21\BookingApp\Shared\ValueObject\Email;

use Faker\Factory as Faker;


class JsonBookingRepository implements BookingRepository
{
    private string $filePath;

    public function __construct(string $dataDir)
    {
        $this->filePath = $dataDir . '/bookings.json';

        if(!file_exists($dataDir)) {
            mkdir($dataDir, 0777, true);
        }

        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
            $this->build();
        }
    }

    public function save(Booking $booking): void
    {
        $bookings = $this->findAll();
        $bookings[] = $booking;
        $this->persistAll($bookings);
    }

    public function findAll(): array
    {
        $json = file_get_contents($this->filePath);
        $data = json_decode($json, true);

        return array_map(function ($item) {
            return new Booking(
                new BookingId($item['id']),
                new HotelId($item['hotelId']),
                $item['roomsQty'],
                new Email($item['email']),
                $item['name'],
                $item['lastName']
            );
        }, $data);
    }

    private function persistAll(array $bookings): void
    {
        $data = array_map(function (Booking $b) {
            return [
                'id' => (string) $b->getId(),
                'hotelId' => (string) $b->getHotelId(),
                'roomsQty' => $b->getRoomsQty(),
                'email' => (string) $b->getEmail(),
                'name' => $b->getName(),
                'lastName' => $b->getLastName(),
            ];
        }, $bookings);

        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function findByHotel(HotelId $hotelId): array
    {
        $bookings = $this->findAll();
        return array_filter($bookings, function (Booking $b) use ($hotelId) {
            return $b->getHotelId()->equals($hotelId);
        });
    }

    private function build(): void
    {
        $bookings = $this->findAll();
        $faker = Faker::create();
        $hotels = (new InMemoryHotelRepository())->findAll();
        // generate 15 random bookings  
        for ($i = 0; $i < 15; $i++) {
            $bookings[] = new Booking( BookingId::generate(), $hotels[array_rand($hotels)]->getId(), rand(1, 10), new Email($faker->email()), $faker->name(), $faker->lastName());
        }
        $this->persistAll($bookings);
    }
    
    
}


