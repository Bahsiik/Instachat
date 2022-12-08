<?php
declare(strict_types=1);

require_once('src/controllers/Delete.php');
require_once('src/controllers/friend/GetFriendRequests.php');
require_once('src/controllers/friend/GetFriends.php');
require_once('src/controllers/friend/GetSentRequests.php');
require_once('src/controllers/pages/AuthentificationPage.php');
require_once('src/controllers/pages/FriendPage.php');
require_once('src/controllers/pages/HomePage.php');
require_once('src/controllers/pages/OptionsPage.php');
require_once('src/controllers/pages/TrendPage.php');
require_once('src/controllers/post/AddPost.php');
require_once('src/controllers/post/GetComments.php');
require_once('src/controllers/post/GetFeed.php');
require_once('src/controllers/post/GetTrends.php');
require_once('src/controllers/user/CreateUser.php');
require_once('src/controllers/user/GetConnectedUser.php');
require_once('src/controllers/user/LoginUser.php');
require_once('src/controllers/user/UpdatePreferences.php');
require_once('src/lib/utils.php');
require_once('src/model/Post.php');

use Controllers\Delete;
use Controllers\Friend\GetFriendRequests;
use Controllers\Friend\GetFriends;
use Controllers\Friend\GetSentRequests;
use Controllers\Pages\AuthentificationPage;
use Controllers\Pages\FriendPage;
use Controllers\Pages\HomePage;
use Controllers\Pages\OptionsPage;
use Controllers\Pages\TrendPage;
use Controllers\Post\AddPost;
use Controllers\Post\GetFeed;
use Controllers\Post\GetTrends;
use Controllers\User\CreateUser;
use Controllers\User\GetConnectedUser;
use Controllers\User\LoginUser;
use Controllers\User\UpdatePreferences;
use Model\User;
use function Lib\Utils\redirect;
use function Lib\Utils\redirect_if_method_not;

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
			global $trends;
			$posts = (new GetFeed())->execute($_SESSION);
			$trends = (new GetTrends())->execute();
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
			(new Delete())->execute(array_merge($_POST, ['type' => $_GET['type'] ?? '']));
			break;

		case 'options':
			(new OptionsPage())->execute($connected_user);
			break;

		case 'update-preferences':
			redirect_if_method_not('POST', '/options');
			(new UpdatePreferences())->execute($connected_user, $_POST);
			break;

		case 'trend':
			redirect_if_method_not('GET', '/');

			(new TrendPage())->execute($connected_user);
			break;

		case 'friends':
			redirect_if_method_not('GET', '/');
			global $friend_list;
			global $friend_requests;
			global $sent_requests;
			$friend_list = (new GetFriends())->execute($connected_user);
			$friend_requests = (new GetFriendRequests())->execute($connected_user);
			$sent_requests = (new GetSentRequests())->execute($connected_user);
			(new FriendPage())->execute($connected_user);
			echo json_encode($friend_list);
			echo '<br><br>';
			echo json_encode($friend_requests);
			echo '<br><br>';
			echo json_encode($sent_requests);
			break;
	}
} catch (Exception $exception) {
	echo '<pre>';
	echo 'Exception: ' . $exception->getMessage();
	$previous = $exception->getPrevious();

	while ($previous !== null) {
		echo '<br>Previous: ' . $previous->getMessage();
		$previous = $previous->getPrevious();
	}
	echo '</pre>';
}
