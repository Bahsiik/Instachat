<?php
declare(strict_types=1);
require_once 'src/controllers/Delete.php';
require_once 'src/controllers/comments/AddComment.php';
require_once 'src/controllers/comments/CountComments.php';
require_once 'src/controllers/comments/DownVoteComment.php';
require_once 'src/controllers/comments/GetCommentsFeed.php';
require_once 'src/controllers/comments/GetCommentVotes.php';
require_once 'src/controllers/comments/UnVoteComment.php';
require_once 'src/controllers/comments/UpVoteComment.php';
require_once 'src/controllers/friends/GetFriendRequests.php';
require_once 'src/controllers/friends/GetFriends.php';
require_once 'src/controllers/friends/GetSentRequests.php';
require_once 'src/controllers/friends/RemoveFriend.php';
require_once 'src/controllers/friends/SendRequest.php';
require_once 'src/controllers/friends/AcceptRequest.php';
require_once 'src/controllers/friends/DeclineRequest.php';
require_once 'src/controllers/friends/CancelRequest.php';
require_once 'src/controllers/pages/AuthentificationPage.php';
require_once 'src/controllers/pages/FriendPage.php';
require_once 'src/controllers/pages/HomePage.php';
require_once 'src/controllers/pages/OptionsPage.php';
require_once 'src/controllers/pages/TrendPage.php';
require_once 'src/controllers/pages/SearchTrendPage.php';
require_once 'src/controllers/pages/PostPage.php';
require_once 'src/controllers/pages/ProfilePage.php';
require_once 'src/controllers/posts/AddPost.php';
require_once 'src/controllers/posts/GetFeed.php';
require_once 'src/controllers/posts/GetTrends.php';
require_once 'src/controllers/posts/GetPostContaining.php';
require_once 'src/controllers/posts/GetPostsByUser.php';
require_once 'src/controllers/users/CreateUser.php';
require_once 'src/controllers/users/GetConnectedUser.php';
require_once 'src/controllers/users/GetUser.php';
require_once 'src/controllers/users/GetUserByUsername.php';
require_once 'src/controllers/users/LoginUser.php';
require_once 'src/controllers/users/UpdatePassword.php';
require_once 'src/controllers/users/UpdatePreferences.php';
require_once 'src/controllers/users/UpdateUserInformation.php';
require_once 'src/lib/utils.php';
require_once 'src/lib/dateUtils.php';
require_once 'src/models/Blocked.php';
require_once 'src/models/Comment.php';
require_once 'src/models/Friend.php';
require_once 'src/models/Post.php';
require_once 'src/models/Reaction.php';
require_once 'src/models/Votes.php';

use Controllers\comments\AddComment;
use Controllers\comments\UnVoteComment;
use Controllers\comments\UpVoteComment;
use Controllers\Delete;
use Controllers\Friends\AcceptRequest;
use Controllers\Friends\CancelRequest;
use Controllers\Friends\DeclineRequest;
use Controllers\Friends\GetFriendRequests;
use Controllers\Friends\GetFriends;
use Controllers\Friends\GetSentRequests;
use Controllers\Friends\RemoveFriend;
use Controllers\Friends\SendRequest;
use Controllers\Pages\AuthentificationPage;
use Controllers\Pages\FriendPage;
use Controllers\Pages\HomePage;
use Controllers\Pages\OptionsPage;
use Controllers\Pages\PostPage;
use Controllers\Pages\ProfilePage;
use Controllers\Pages\SearchTrendPage;
use Controllers\Posts\AddPost;
use Controllers\Posts\GetFeed;
use Controllers\Posts\GetPostContaining;
use Controllers\Posts\GetPostsByUser;
use Controllers\Posts\GetTrends;
use Controllers\Users\CreateUser;
use Controllers\Users\GetConnectedUser;
use Controllers\Users\GetUserByUsername;
use Controllers\Users\LoginUser;
use Controllers\Users\UpdatePassword;
use Controllers\Users\UpdatePreferences;
use Controllers\Users\UpdateUserInformation;
use Models\User;
use Src\Controllers\comments\DownVoteComment;
use Src\Controllers\comments\GetCommentsFeed;
use function Lib\Utils\redirect;
use function Lib\Utils\redirect_if_method_not;
use function Lib\Utils\writeLog;

session_start();
date_default_timezone_set('Europe/Paris');

$filename = 'log.txt';

try {
	$method = $_SERVER['REQUEST_METHOD'] ?? '';
	$uri_segments = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	$first_segment = $uri_segments[1] ?? '';
	global $second_segment;
	$second_segment = $uri_segments[2] ?? '';

	/**
	 * @var User $connected_user
	 */
	global $connected_user;
	$connected_user = (new GetConnectedUser())->execute($_SESSION);
	if ($connected_user !== null && $method === 'GET') {
		$_SESSION['expire'] = time() + 3600;
		if (time() > $_SESSION['expire']) session_destroy();
	}
	if ($connected_user === null && $first_segment !== 'create' && $method === 'GET') redirect('/create');

	switch ($first_segment) {
		default:
			global $posts, $trends;
			$posts = (new GetFeed())->execute($connected_user);
			$trends = (new GetTrends())->execute();
			(new HomePage())->execute();
			$data = writeLog('HOME-PAGE');
			file_put_contents($filename, $data, FILE_APPEND);
			break;

		case 'getFeed':
			redirect_if_method_not('GET', '/');
			$posts = (new GetFeed())->execute($connected_user);
			$data = writeLog('FEED-PAGE');
			file_put_contents($filename, $data, FILE_APPEND);
			global $post;
			foreach ($posts as $post) require 'templates/components/post.php';

			exit();

		case 'comments':
			redirect_if_method_not('GET', '/');
			$post_id = (float)($_GET['post-id'] ?? 0);

			$comments = (new GetCommentsFeed())->execute($post_id);
			global $comment;
			foreach ($comments as $comment) require 'templates/components/comment.php';

			exit();

		case 'post':
			redirect_if_method_not('GET', '/');
			global $trends;
			$trends = (new GetTrends())->execute();
			(new PostPage())->execute($_GET);
			$data = writeLog('POST-PAGE', "[POST-ID:{$_GET['id']}]");
			file_put_contents($filename, $data, FILE_APPEND);
			break;

		case 'create':
			if ($method === 'GET') {
				(new AuthentificationPage())->execute();
				$data = writeLog('CREATE-PAGE');
				file_put_contents($filename, $data, FILE_APPEND);
			} else {
				$data = writeLog('CREATE-USER', "[USER-USERNAME:{$_POST['username']}] [USER-EMAIL:{$_POST['email']}]");
				file_put_contents($filename, $data, FILE_APPEND);
				(new CreateUser())->execute($_POST);
			}
			break;

		case 'login':
			redirect_if_method_not('POST', '/');
			$data = writeLog('LOGIN-USER', "[USER:{$_POST['email']}]");
			file_put_contents($filename, $data, FILE_APPEND);
			(new LoginUser())->execute($_POST);
			break;

		case 'logout':
			$data = writeLog('LOGOUT-USER', "[USER-NAME:{$connected_user->username}] [USER-EMAIL:{$connected_user->email}]");
			file_put_contents($filename, $data, FILE_APPEND);
			session_destroy();
			redirect('/');

		case 'chat':
			redirect_if_method_not('POST', '/');
			$is_there_image = (strlen($_FILES['image-content']['tmp_name']) > 0) ? 'true' : 'false';
			$data = writeLog('ADD-POST', "[USER:{$connected_user->username}] [POST-CONTENT:{$_POST['content']}, POST-IMAGE:{$is_there_image}]");
			file_put_contents($filename, $data, FILE_APPEND);
			(new AddPost())->execute($connected_user, $_POST);
			break;

		case 'comment':
			redirect_if_method_not('POST', '/');
			$data = writeLog('ADD-COMMENT', "[USER:{$connected_user->username}] [COMMENT-CONTENT:{$_POST['content']}]");
			file_put_contents($filename, $data, FILE_APPEND);
			(new AddComment())->execute($connected_user, $_POST);
			break;

		case 'delete':
			redirect_if_method_not('POST', '/');
			$type = strtoupper($_GET['type']);
			$get_id = ($type == 'POST') ? $_POST['post_id'] : (($type == 'COMMENT') ? $_POST['comment_id'] :
				(($type == 'USER') ? $connected_user->id : (($type == 'REACTION') ?
					$_POST['post_id'] : null)));
			$data = writeLog("DELETE-{$type}", "[{$type}-ID:{$get_id}]");
			file_put_contents($filename, $data, FILE_APPEND);
			(new Delete())->execute(array_merge($_POST, ['type' => $_GET['type'] ?? '']));
			break;

		case 'options':
			$data = writeLog('OPTIONS-PAGE');
			file_put_contents($filename, $data, FILE_APPEND);
			(new OptionsPage())->execute();
			break;

		case 'update-preferences':
			redirect_if_method_not('POST', '/options');
			$data = writeLog('UPDATE-PREFERENCES');
			file_put_contents($filename, $data, FILE_APPEND);
			(new UpdatePreferences())->execute($connected_user, $_POST);
			break;

		case 'update-password':
			redirect_if_method_not('POST', '/options');
			$data = writeLog('UPDATE-PASSWORD');
			file_put_contents($filename, $data, FILE_APPEND);
			(new UpdatePassword())->execute($connected_user, $_POST);
			break;

		case 'update-user-information':
			redirect_if_method_not('POST', '/options');
			$data = writeLog('UPDATE-INFORMATIONS');
			file_put_contents($filename, $data, FILE_APPEND);
			(new UpdateUserInformation())->execute($connected_user, $_POST);
			break;

		case 'friends':
			redirect_if_method_not('GET', '/');
			$data = writeLog('FRIENDS-PAGE');
			file_put_contents($filename, $data, FILE_APPEND);
			global $friend_list, $friend_requests, $sent_requests, $trends;
			$friend_list = (new GetFriends())->execute($connected_user);
			$friend_requests = (new GetFriendRequests())->execute($connected_user);
			$sent_requests = (new GetSentRequests())->execute($connected_user);
			$trends = (new GetTrends())->execute();
			(new FriendPage())->execute();
			break;

		case 'send-friend-request':
			redirect_if_method_not('POST', '/');
			$data = writeLog('SEND-FRIEND-REQUEST', "[FROM-USER-ID:{$connected_user->id}] [TO-USER-ID:{$_POST['requested_id']}]");
			file_put_contents($filename, $data, FILE_APPEND);
			(new SendRequest())->execute($connected_user, $_POST);
			break;

		case 'remove-friend':
			redirect_if_method_not('POST', '/');
			$data = writeLog('REMOVE-FRIEND', "[USER-ID:{$connected_user->id}] [REMOVED-USER-ID:{$_POST['friend_id']}]");
			file_put_contents($filename, $data, FILE_APPEND);
			(new RemoveFriend())->execute($connected_user, $_POST);
			break;

		case 'accept-friend':
			redirect_if_method_not('POST', '/');
			$data = writeLog('ACCEPT-FRIEND', "[USER-ID:{$connected_user->id}] [ACCEPTED-USER-ID:{$_POST['requester_id']}]");
			file_put_contents($filename, $data, FILE_APPEND);
			(new AcceptRequest())->execute($connected_user, $_POST);
			break;

		case'decline-friend':
			redirect_if_method_not('POST', '/');
			$data = writeLog('DECLINE-FRIEND', "[USER-ID:{$connected_user->id}] [DECLINED-USER-ID:{$_POST['requester_id']}]");
			file_put_contents($filename, $data, FILE_APPEND);
			(new DeclineRequest())->execute($connected_user, $_POST);
			break;

		case 'cancel-friend':
			redirect_if_method_not('POST', '/');
			$data = writeLog('CANCEL-FRIEND', "[USER-ID:{$connected_user->id}] [CANCELED-USER-ID:{$_POST['requested_id']}]");
			file_put_contents($filename, $data, FILE_APPEND);
			(new CancelRequest())->execute($connected_user, $_POST);
			break;

		case 'search-trend':
			redirect_if_method_not('GET', '/');
			global $searched_trend, $searched_posts, $trends;
			$searched_trend = $_GET['trend'];
			$data = writeLog('SEARCH-TREND-PAGE', "[TREND:{$searched_trend}]");
			file_put_contents($filename, $data, FILE_APPEND);
			$searched_posts = (new GetPostContaining())->execute($_GET['trend']);
			$trends = (new GetTrends())->execute();
			if (isset($trends[$searched_trend])) (new SearchTrendPage())->execute(); else redirect('/');
			break;

		case 'profile':
			if ($second_segment === null) redirect("/profile/$connected_user->username");
			$user = (new GetUserByUsername())->execute($second_segment);
			if ($user === null) redirect('/');

			if (isset($_GET['offset'])) {
				$user_posts = (new GetPostsByUser())->execute($user->id);
				global $post;
				foreach ($user_posts as $post) require 'templates/components/post.php';
				exit();
			}

			redirect_if_method_not('GET', '/');

			global $user, $friend_list, $friend_requests, $sent_requests, $user_posts, $trends;

			$friend_list = (new GetFriends())->execute($user);
			$friend_requests = (new GetFriendRequests())->execute($connected_user);
			$sent_requests = (new GetSentRequests())->execute($connected_user);
			$user_posts = (new GetPostsByUser())->execute($user->id);
			$trends = (new GetTrends())->execute();
			(new ProfilePage())->execute();
			break;

		case 'up-vote':
			redirect_if_method_not('POST', '/');
			$data = writeLog('UP-VOTE', "[USER-ID:{$connected_user->id}] [COMMENT-ID:{$_POST['comment-id']}]");
			file_put_contents($filename, $data, FILE_APPEND);
			(new UpVoteComment())->execute($connected_user, $_POST);
			break;

		case 'un-vote':
			redirect_if_method_not('POST', '/');
			$data = writeLog('UN-VOTE', "[USER-ID:{$connected_user->id}] [COMMENT-ID:{$_POST['comment-id']}]");
			file_put_contents($filename, $data, FILE_APPEND);
			(new UnVoteComment())->execute($connected_user, $_POST);
			break;

		case 'down-vote':
			redirect_if_method_not('POST', '/');
			$data = writeLog('DOWN-VOTE', "[USER-ID:{$connected_user->id}] [COMMENT-ID:{$_POST['comment-id']}]");
			file_put_contents($filename, $data, FILE_APPEND);
			(new DownVoteComment())->execute($connected_user, $_POST);
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
