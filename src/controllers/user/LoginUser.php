<?php

namespace Controllers\User;

require_once('src/model/User.php');

use Exception;
use Model\UserRepository;
use RuntimeException;
use function Lib\Utils\redirect;

class LoginUser
{
    /**
     * @throws Exception
     */
    public function execute(array $input): void
    {
        $log_in = ['email', 'password'];
        foreach ($log_in as $value) {
            if (!isset($input[$value])) throw new RuntimeException('Invalid input');
        }
        $user = (new UserRepository())->loginUser($input['email'], $input['password']);
        if($user){
            $user = (new UserRepository())->getUserIdByEmailOrUsername($input['email']);
            $session_id = (new UserRepository())->createSession((int)$user['id']);
            setcookie('session_id', $session_id, time() + 3600, '/');
            redirect('index.php');
        } else {
            redirect('index.php?create');
        }
    }

}