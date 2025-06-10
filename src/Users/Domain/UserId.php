<?php
declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Users\Domain;

final class UserId
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
