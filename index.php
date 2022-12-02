<?php

require_once('src/controllers/pages/AuthentificationPage.php');
require_once('src/controllers/pages/HomePage.php');
require_once('src/controllers/user/CreateUser.php');
require_once('src/controllers/user/GetConnectedUser.php');
require_once('src/controllers/user/LoginUser.php');
require_once('src/controllers/post/GetTrends.php');
require_once('src/controllers/post/AddPost.php');

use Controllers\Pages\AuthentificationPage;
use Controllers\Pages\HomePage;
use Controllers\Post\AddPost;
use Controllers\Post\GetTrends;
use Controllers\User\CreateUser;
use Controllers\User\GetConnectedUser;
use Controllers\User\LoginUser;

try {
    /**
     * @type string $action
     */
    $action = $_SERVER['QUERY_STRING'] ?? '';

    switch ($action) {
        default:
            (new HomePage())->execute();
            break;
        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                (new AuthentificationPage())->execute();
                break;
            }
            (new CreateUser())->execute($_POST);
            break;
        case 'login':
            (new LoginUser())->execute($_POST);
            break;
        case 'chat':
            $connected_user = (new GetConnectedUser())->execute($_SESSION);
            (new AddPost())->execute($connected_user, $_POST);
            break;

        case 'trend':
            $trends = (new GetTrends())->execute();
            echo json_encode($trends);
            break;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}