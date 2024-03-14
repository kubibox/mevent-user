<?php

namespace App\Auth\Domain\Register;

final class RegisteredUser
{
    public function __construct(
        private readonly ?int $id,
        private readonly ?string $email,
    ) {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function isUnique(): bool
    {
        return !$this->email && !$this->id;
    }
}
