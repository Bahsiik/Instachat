<?php
declare(strict_types=1);

require_once('src/controllers/Delete.php');
require_once('src/controllers/friend/GetFriendRequests.php');
require_once('src/controllers/friend/GetFriends.php');
require_once('src/controllers/friend/GetSentRequests.php');
require_once('src/controllers/friend/RemoveFriend.php');
require_once('src/controllers/friend/AcceptRequest.php');
require_once('src/controllers/friend/DeclineRequest.php');
require_once('src/controllers/friend/CancelRequest.php');
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
require_once('src/controllers/user/GetUser.php');
require_once('src/controllers/user/LoginUser.php');
require_once('src/controllers/user/UpdatePreferences.php');
require_once('src/lib/utils.php');
require_once('src/lib/dateUtils.php');
require_once('src/model/Post.php');

use Controllers\Delete;
use Controllers\Friend\AcceptRequest;
use Controllers\Friend\CancelRequest;
use Controllers\Friend\DeclineRequest;
use Controllers\Friend\GetFriendRequests;
use Controllers\Friend\GetFriends;
use Controllers\Friend\GetSentRequests;
use Controllers\Friend\RemoveFriend;
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
			$posts = (new GetFeed())->execute($connected_user);
			$trends = (new GetTrends())->execute();
			(new HomePage())->execute();
			break;

		case 'getFeed':
			redirect_if_method_not('GET', '/');
			$posts = (new GetFeed())->execute($connected_user);
			global $post;
			foreach ($posts as $post) {
				require('templates/post.php');
			}

			exit();

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

		case 'friends':
			redirect_if_method_not('GET', '/');
			global $friend_list;
			global $friend_requests;
			global $sent_requests;
			global $trends;
			$friend_list = (new GetFriends())->execute($connected_user);
			$friend_requests = (new GetFriendRequests())->execute($connected_user);
			$sent_requests = (new GetSentRequests())->execute($connected_user);
			$trends = (new GetTrends())->execute();
			(new FriendPage())->execute($connected_user);
			break;

		case 'remove-friend':
			redirect_if_method_not('POST', '/friends');
			(new RemoveFriend())->execute($connected_user, $_POST);
			break;

		case 'accept-friend':
			redirect_if_method_not('POST', '/friends');
			(new AcceptRequest())->execute($connected_user, $_POST);
			break;

		case'decline-friend':
			redirect_if_method_not('POST', '/friends');
			(new DeclineRequest())->execute($connected_user, $_POST);
			break;

		case 'cancel-friend':
			redirect_if_method_not('POST', '/friends');
			(new CancelRequest())->execute($connected_user, $_POST);
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
