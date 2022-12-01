<?php

namespace Controllers\User;

require_once('src/model/user.php');

use Model\UserRepository;

class CreateUser
{
    public function execute(array $input): void
    {
        $birth_date = date_create($input['birthdate']);
        (new UserRepository())->createUser($input['username'], $input['email'],  $input['password'], $input['gender'], $birth_date);
    }
}