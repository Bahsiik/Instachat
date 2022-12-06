<?php

require_once('src/controllers/pages/AuthentificationPage.php');
require_once('src/controllers/pages/HomePage.php');
require_once('src/controllers/pages/FriendPage.php');
require_once('src/controllers/pages/OptionsPage.php');
require_once('src/controllers/post/AddPost.php');
require_once('src/controllers/post/GetTrends.php');
require_once('src/controllers/post/GetFeed.php');
require_once('src/controllers/post/GetComments.php');
require_once('src/controllers/user/CreateUser.php');
require_once('src/controllers/user/GetConnectedUser.php');
require_once('src/controllers/user/LoginUser.php');
require_once('src/controllers/friend/GetFriends.php');
require_once('src/controllers/friend/GetFriendRequests.php');
require_once('src/controllers/friend/GetSentRequests.php');
require_once('src/lib/utils.php');
require_once('src/model/Post.php');

use Controllers\Friend\GetFriendRequests;
use Controllers\Friend\GetFriends;
use Controllers\Friend\GetSentRequests;
use Controllers\Pages\AuthentificationPage;
use Controllers\Pages\FriendPage;
use Controllers\Pages\HomePage;
use Controllers\Pages\OptionsPage;
use Controllers\Post\AddPost;
use Controllers\Post\GetFeed;
use Controllers\Post\GetTrends;
use Controllers\User\CreateUser;
use Controllers\User\GetConnectedUser;
use Controllers\User\LoginUser;
use function Lib\Utils\redirect;
use function Lib\Utils\redirect_if_method_not;

session_start();
date_default_timezone_set('Europe/Paris');

try {
	$method = $_SERVER['REQUEST_METHOD'] ?? '';
	$uriSegments = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	$firstSegment = $uriSegments[1] ?? '';

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
			echo "<br><br>";
			echo json_encode($friend_requests);
			echo "<br><br>";
			echo json_encode($sent_requests);
			break;
	}
} catch (Exception $e) {
	echo $e->getMessage();
}