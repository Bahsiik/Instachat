<?php

require_once('vendor/autoload.php');

use Src\Controllers\Friends\GetFriendRequests;
use Src\Controllers\Friends\GetFriends;
use Src\Controllers\Friends\GetSentRequests;
use Src\Controllers\Pages\AuthentificationPage;
use Src\Controllers\Pages\FriendPage;
use Src\Controllers\Pages\HomePage;
use Src\Controllers\Pages\OptionsPage;
use Src\Controllers\Post\AddPost;
use Src\Controllers\Post\GetFeed;
use Src\Controllers\Post\GetTrends;
use Src\Controllers\Users\CreateUser;
use Src\Controllers\Users\GetConnectedUser;
use Src\Controllers\Users\LoginUser;
use Src\Models\User;
use function Src\Lib\Utils\redirect;
use function Src\Lib\Utils\redirect_if_method_not;

session_start();
date_default_timezone_set('Europe/Paris');

try {
	$method = $_SERVER['REQUEST_METHOD'] ?? '';
	$uriSegments = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	$firstSegment = $uriSegments[1] ?? '';

	/**
	 * @var User $connected_user
	 */
	global $connected_user;
	$connected_user = (new GetConnectedUser())->execute($_SESSION);
	if ($connected_user !== null && $method === 'GET') {
		$_SESSION['expire'] = time() + 3600;
		if (time() > $_SESSION['expire']) {
			session_destroy();
		}
	}
	if ($connected_user === null && $firstSegment !== 'create' && $method === 'GET') {
		redirect('/create');
	}

	switch ($firstSegment) {
		default:
			global $posts;
			$posts = (new GetFeed())->execute($_SESSION);
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

		case 'chat':
			redirect_if_method_not('POST', '/');
			(new AddPost())->execute($connected_user, $_POST);
			break;

		case 'delete':
			redirect_if_method_not('POST', '/');
			(new DeletePost())->execute($connected_user, $_POST);
			break;

		case 'options':
			(new OptionsPage())->execute($connected_user);
			break;

		case 'trend':
			redirect_if_method_not('GET', '/');
			$trends = (new GetTrends())->execute();
			echo json_encode($trends);
			break;

		case 'friends':
			redirect_if_method_not('GET', '/');
			global $friend_list;
			$friend_list = (new GetFriends())->execute($connected_user);
			global $friend_requests;
			$friend_requests = (new GetFriendRequests())->execute($connected_user);
			global $sent_requests;
			$sent_requests = (new GetSentRequests())->execute($connected_user);
			(new FriendPage())->execute($connected_user);
			echo json_encode($friend_list);
			echo '<br><br>';
			echo json_encode($friend_requests);
			echo '<br><br>';
			echo json_encode($sent_requests);
			break;
	}
} catch (Exception $e) {
	echo $e->getMessage();
}
