<?php

require_once('src/controllers/pages/AuthentificationPage.php');
require_once('src/controllers/pages/HomePage.php');
//require_once('src/controllers/pages/OptionsPage.php');
require_once('src/controllers/post/AddPost.php');
require_once('src/controllers/post/GetTrends.php');
require_once('src/controllers/user/CreateUser.php');
require_once('src/controllers/user/GetConnectedUser.php');
require_once('src/controllers/user/LoginUser.php');

use Controllers\Pages\AuthentificationPage;
use Controllers\Pages\HomePage;
use Controllers\Post\AddPost;
use Controllers\Post\GetTrends;
use Controllers\User\CreateUser;
use Controllers\User\GetConnectedUser;
use Controllers\User\LoginUser;
use function Lib\Utils\redirect;
use function Lib\Utils\redirect_if_method_not;

session_start();

try {
	$method = $_SERVER['REQUEST_METHOD'] ?? '';
	$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	$firstSegment = $uriSegments[1] ?? '';
    global $connected_user;
	$connected_user = (new GetConnectedUser())->execute($_SESSION);

    if($connected_user !== null && $method === 'GET') {
        $_SESSION['expire'] = time() + 3600;
        if(time() > $_SESSION['expire']) {
            session_destroy();
        }
    }

    if($connected_user === null && $firstSegment !== 'create' && $method === 'GET') {
        redirect('/create');
    }

	switch ($firstSegment) {
		default:
			(new HomePage())->execute();
			break;

		case 'create':
			if ($method === 'GET') (new AuthentificationPage())->execute();
			else (new CreateUser())->execute($_POST);
			break;

		case 'login':
			redirect_if_method_not('POST', '/');
			(new LoginUser())->execute($_POST);
			break;

        case 'logout':
            session_destroy();
            redirect('/');
            //no break needed

		case 'chat':
			redirect_if_method_not('POST', '/');
			(new AddPost())->execute($connected_user, $_POST);
			break;

		/*case 'options':
			(new OptionsPage())->execute($connected_user);
			break;*/

		case 'trend':
			redirect_if_method_not('POST', '/');
			$trends = (new GetTrends())->execute();
			echo json_encode($trends);
			break;
	}
} catch (Exception $e) {
	echo $e->getMessage();
}