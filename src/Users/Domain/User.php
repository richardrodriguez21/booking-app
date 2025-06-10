<?php

declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Users\Domain;
use Richardrodriguez21\BookingApp\Shared\ValueObject\Email;
use Richardrodriguez21\BookingApp\Users\Domain\UserId;

final class User
{
    private UserId $id;
    private Email $email;

    public function __construct(UserId $id, Email $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    // getters and setters for the properties
    public function getId(): UserId
    {
        return $this->id;
    }   


    public function getEmail(): Email
    {
        return $this->email;
    }

    
}