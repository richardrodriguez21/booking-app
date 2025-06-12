<?php

namespace Tests\Bookings\Domain;

use PHPUnit\Event\Facade;
use PHPUnit\Framework\TestCase;
use Richardrodriguez21\BookingApp\Bookings\Domain\Booking;
use Richardrodriguez21\BookingApp\Bookings\Domain\BookingId;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelId;
use Richardrodriguez21\BookingApp\Shared\ValueObject\Email;
use InvalidArgumentException;
use Faker\Factory as Faker;

class BookingTest extends TestCase
{
    public function test_booking_can_be_created()
    {

        $faker = Faker::create();

        $booking = new Booking(
            BookingId::generate(),
            HotelId::generate(),
            1,
            new Email($faker->email()),
            $faker->firstName(),
            $faker->lastName()
        );

        $this->assertInstanceOf(Booking::class, $booking);
    }

    public function test_booking_can_be_created_with_invalid_email()
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('invalid-email');
    }   

}