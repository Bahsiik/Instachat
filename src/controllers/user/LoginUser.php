<?php

namespace Controllers\User;

require_once('src/model/user.php');

use Model\UserRepository;

class LoginUser
{
    public function execute(array $input): void
    {
        $user = (new UserRepository())->loginUser($input['email'], $input['password']);
        if($user){
            echo "Login successful";
        } else {
            require_once('templates/register.php');
        }
    }

}