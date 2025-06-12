<?php

namespace Richardrodriguez21\BookingApp\Tests\Bookings\Application;

use PHPUnit\Framework\TestCase;
use Richardrodriguez21\BookingApp\Bookings\Application\UniqueUsersPerHotelFinder;
use Richardrodriguez21\BookingApp\Bookings\Domain\Booking;
use Richardrodriguez21\BookingApp\Bookings\Domain\BookingId;
use Richardrodriguez21\BookingApp\Bookings\Domain\BookingRepository;
use Richardrodriguez21\BookingApp\Hotels\Domain\Hotel;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelId;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelRepository;
use Richardrodriguez21\BookingApp\Shared\ValueObject\Email;
use Faker\Factory;


class UniqueUsersPerHotelFinderTest extends TestCase
{
    private BookingRepository $bookingRepository;
    private HotelRepository $hotelRepository;
    private UniqueUsersPerHotelFinder $finder;

    protected function setUp(): void
    {
        $this->bookingRepository = $this->createMock(BookingRepository::class);
        $this->hotelRepository = $this->createMock(HotelRepository::class);
        $this->finder = new UniqueUsersPerHotelFinder(
            $this->bookingRepository,
            $this->hotelRepository
        );
    }

    public function testItShouldReturnUniqueUsersCountPerHotel(): void
    {
        $faker = Factory::create();

        $hotel1Id = HotelId::generate();
        $hotel2Id = HotelId::generate();

        $hotel1 = new Hotel($hotel1Id, $faker->name(), $faker->city(), $faker->country(), $faker->numberBetween(1, 100));
        $hotel2 = new Hotel($hotel2Id, $faker->name(), $faker->city(), $faker->country(), $faker->numberBetween(1, 100));
        
        $this->hotelRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([$hotel1, $hotel2]);

        // Hotel 1 bookings with some duplicate emails
        $hotel1Bookings = [
            $this->createBookingWithEmail('user1@example.com'),
            $this->createBookingWithEmail('user1@example.com'), // duplicate
            $this->createBookingWithEmail('user2@example.com'),
        ];

        // Hotel 2 bookings
        $hotel2Bookings = [
            $this->createBookingWithEmail('user3@example.com'),
            $this->createBookingWithEmail('user4@example.com'),
        ];

        $this->bookingRepository
            ->expects($this->exactly(2))
            ->method('findByHotel')
            ->willReturnCallback(function (HotelId $id) use ($hotel1Bookings, $hotel2Bookings) {
                return $id->getValue() === '1' ? $hotel1Bookings : $hotel2Bookings;
            });

        // Act
        $result = $this->finder->execute();

        // Assert
        $this->assertCount(2, $result);
        
        // Hotel 1 should have 2 unique users
        $this->assertEquals($hotel1Id->getValue(), $result[0]['id']);
        $this->assertEquals(2, $result[0]['users']);
        
        // Hotel 2 should have 2 unique users
        $this->assertEquals($hotel2Id->getValue(), $result[1]['id']);
        $this->assertEquals(2, $result[1]['users']);
    }

    public function testItShouldReturnEmptyArrayWhenNoHotels(): void
    {
      
        $this->hotelRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

       
        $result = $this->finder->execute();

       
        $this->assertEmpty($result);
    }

    private function createBookingWithEmail(string $email): Booking
    {
        $faker = Factory::create();

        $booking = new Booking(
            BookingId::generate(),
            HotelId::generate(),
            $faker->numberBetween(1, 100),
            new Email($email),
            $faker->name(),
            $faker->lastName()
        );
        return $booking;
    }
}   