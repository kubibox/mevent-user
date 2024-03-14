<?php

namespace App\Auth\Domain\Register;

interface RegisterRepository
{
    public function searchByEmail(RegisterEmail $email): RegisteredUser;

    public function createNewUser(RegisterUser $user): RegisteredUser;
}