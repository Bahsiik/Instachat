<?php

require_once('src/controllers/user/CreateUserPage.php');
require_once('src/controllers/user/CreateUser.php');
require_once('src/controllers/user/LoginUser.php');
require_once('src/controllers/post/GetTrends.php');



use Controllers\Post\GetTrends;
use Controllers\User\CreateUser;
use Controllers\User\CreateUserPage;
use Controllers\User\LoginUser;

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
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                (new CreateUserPage())->execute();
                break;
            }
            $sign_in = ['username', 'email', 'password', 'gender', 'birthdate'];
            foreach ($sign_in as $key => $value) {
                if (!isset($_POST[$value])) throw new RuntimeException('Invalid input');
            }
            (new CreateUser())->execute($_POST);
            break;
        case 'login':
            $log_in = ['email', 'password'];
            foreach ($log_in as $key => $value) {
                if (!isset($_POST[$value])) throw new RuntimeException('Invalid input');
            }
            (new LoginUser())->execute($_POST);
            break;

        case 'trend':
            $trends = (new GetTrends())->execute();
            echo json_encode($trends);
            break;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}