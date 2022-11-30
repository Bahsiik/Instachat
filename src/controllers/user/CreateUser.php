<?php

namespace Controllers\User;

use Model\User;
use Model\UserRepository;

class CreateUser
{
    public function execute(array $input): void
    {
        (new UserRepository())->createUser($input['username'], $input['email'],  $input['password'], $input['gender'], $input['birthdate']);
    }

}