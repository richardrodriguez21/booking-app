<?php

declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Shared\ValueObject;
use Symfony\Component\Uid\Ulid as SymfonyUlid;


abstract class Ulid
{
    private string $value;

    final public function __construct(string $value){
        $this->isValid($value);
        $this->value = $value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    final public static function generate(): self{
        return new static(SymfonyUlid::generate());
    }

    public function __toString(): string
    {
        return $this->value;
    }

    final public function getValue(): string
    {
        return $this->value;
    }

     public function isValid(string $value): void
    {
        if (!SymfonyUlid::isValid($value)) {
            throw new \InvalidArgumentException('Invalid UUID');
        }
    }
    
    
}
