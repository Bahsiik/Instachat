<?php

require_once('src/controllers/user/CreateUserPage.php');
require_once('src/controllers/user/CreateUser.php');


use Controllers\User\CreateUser;
use Controllers\User\CreateUserPage;

try {
    /**
     * @type string $action
     */
    $action = $_SERVER['QUERY_STRING'] ?? '';

    switch ($action) {
//        default:
//            (new Homepage())->execute();
//            break;
        case 'create':
            if($_SERVER['REQUEST_METHOD'] === 'GET') {
                (new CreateUserPage())->execute();
                echo 'get';
                break;
            }
            $sign_in = ['username','email','password','gender','birthdate'];
            foreach ($sign_in as $key => $value) {
                if (!isset($_POST[$value])) throw new RuntimeException('Invalid input');
            }
            (new CreateUser())->execute($_POST);
            break;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}