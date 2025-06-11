<?php

declare(strict_types=1);

namespace Richardrodriguez21\BookingApp\Users\Infrastructure\Persistence;
use Richardrodriguez21\BookingApp\Users\Domain\UserRepository;
use Richardrodriguez21\BookingApp\Users\Domain\User;
use Richardrodriguez21\BookingApp\Users\Domain\UserId;
use Richardrodriguez21\BookingApp\Shared\ValueObject\Email;
use Faker\Factory as Faker;  

final class InMemoryUserRepository implements UserRepository
{
    /** @var array<string, User> */
    private array $users = [];
   
    public function __construct()
    {
        $this->build();
    }

    public function findById(UserId $id): ?User
    {
        return $this->users[(string) $id] ?? null;
    }

    public function findByEmail(Email $email): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getEmail()->equals($email)) {
                return $user;
            }
        }
        return null;
    }

    public function save(User $user): void
    {
        $this->users[(string) $user->getId()] = $user;
    }

    public function findAll(): array
    {
        return array_values($this->users);
    }
    

    private function build(){
        $faker = Faker::create();

        foreach (range(1, 10) as $number) {
            $this->save(new User(UserId::generate(), new Email($faker->email())));
        }
    }
}