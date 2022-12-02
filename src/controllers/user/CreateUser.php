<?php

namespace Controllers\User;

require_once('src/model/user.php');
require_once('src/lib/utils.php');

use Model\UserRepository;
use function Lib\Utils\redirect;

class CreateUser
{
    public function execute(array $input): void
    {
        $user_exist = (new UserRepository())->isUserAlreadyRegistered($input['email'], $input['username']);
        if($user_exist) {
            echo("User already exists");
            redirect('index.php?create');
            return;
        }
        $birth_date = date_create($input['birthdate']);
        (new UserRepository())->createUser($input['username'], $input['email'],  $input['password'], $input['gender'], $birth_date);
    }
}