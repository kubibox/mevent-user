<?php

namespace App\Register\Domain;

interface RegisterRepository
{
    public function searchByEmail(RegisterEmail $email): ?RegisteredUser;

    public function createNewUser(RegisterUser $user): RegisteredUser;
}
