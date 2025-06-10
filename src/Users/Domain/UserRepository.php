<?php

declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Users\Domain;
use Richardrodriguez21\BookingApp\Shared\ValueObject\Email;

interface UserRepository
{
    public function findByEmail(Email $email): ?User;
    public function save(User $user): void;
}