<?php

namespace Controllers\User;

require_once('src/model/user.php');

use Exception;
use Model\UserRepository;

class LoginUser
{
    /**
     * @throws Exception
     */
    public function execute(array $input): void
    {
        $user = (new UserRepository())->loginUser($input['email'], $input['password']);
        if($user){
            echo "Login successful\n";
            $user = (new UserRepository())->getUserIdByEmailOrUsername($input['email']);
            $session_id = (new UserRepository())->createSession((int)$user['id']);
            setcookie('session_id', $session_id, time() + 3600, '/');
        } else {
            require_once('templates/register.php');
        }
    }

}