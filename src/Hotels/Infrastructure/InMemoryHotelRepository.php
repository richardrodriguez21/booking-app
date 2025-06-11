<?php

declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Hotels\Infrastructure;
use Richardrodriguez21\BookingApp\Hotels\Domain\Hotel;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelId;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelRepository;
use Faker\Factory as Faker;


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
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $this->save(new Hotel(HotelId::generate(), $faker->city . ' Hotel', $faker->city, $faker->country, $faker->numberBetween(1, 100)));
        }
    }
}