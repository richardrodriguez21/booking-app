<?php

namespace Tests\Bookings\Application;

use PHPUnit\Framework\TestCase;
use Richardrodriguez21\BookingApp\Bookings\Application\BookingCreator;
use Richardrodriguez21\BookingApp\Bookings\Domain\BookingRepository;
use Richardrodriguez21\BookingApp\Bookings\Domain\Booking;
use Richardrodriguez21\BookingApp\Hotels\Domain\HotelId;
use Richardrodriguez21\BookingApp\Shared\ValueObject\Email;

class BookingCreatorTest extends TestCase
{
    public function test_booking_can_be_created()
    {
        // Mock the bookings repository
        $bookingsRepository = $this->createMock(BookingRepository::class);

        $hotelId = HotelId::generate();
        $email = new Email('test@test.com');   
        $name = 'John';
        $lastName = 'Doe';
        $roomsQty = 2;

        $bookingsRepository->expects($this->once())
            ->method('save')
            ->with($this->callback(function (Booking $booking) use ($hotelId, $email, $name, $lastName, $roomsQty) {
                $this->assertInstanceOf(Booking::class, $booking);
                $this->assertTrue($booking->getHotelId()->equals($hotelId));
                $this->assertTrue($booking->getEmail()->equals($email));
                $this->assertSame($name, $booking->getName());
                $this->assertSame($lastName, $booking->getLastName());
                $this->assertSame($roomsQty, $booking->getRoomsQty());
                return true;
            }));

        $bookingCreator = new BookingCreator($bookingsRepository);
        $bookingCreator->execute(
            $hotelId,
            $email,
            $name,
            $lastName,
            $roomsQty
        );
    }

    public function test_it_throws_exception_for_invalid_hotel_id()
    {
        $bookingsRepository = $this->createMock(BookingRepository::class);
        $bookingCreator = new BookingCreator($bookingsRepository);

        $invalidHotelId = 'not-a-valid-ulid';
        $email = 'test@test.com';
        $name = 'John';
        $lastName = 'Doe';
        $roomsQty = 2;

        $this->expectException(\InvalidArgumentException::class);
        $bookingCreator->execute(
            $invalidHotelId,
            $email,
            $name,
            $lastName,
            $roomsQty
        );
    }
}

