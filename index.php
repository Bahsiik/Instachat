<?php
declare(strict_types=1);
require_once 'src/controllers/Delete.php';
require_once 'src/controllers/blocked/BlockUser.php';
require_once 'src/controllers/blocked/UnblockUser.php';
require_once 'src/controllers/blocked/BlockWord.php';
require_once 'src/controllers/blocked/UnblockWord.php';
require_once 'src/controllers/blocked/GetBlockedUsers.php';
require_once 'src/controllers/blocked/IsBlocked.php';
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
require_once 'src/controllers/reactions/AddReaction.php';
require_once 'src/controllers/reactions/CreateReaction.php';
require_once 'src/controllers/reactions/DeleteReaction.php';
require_once 'src/controllers/reactions/GetReactionsByPost.php';
require_once 'src/controllers/reactions/CreateReaction.php';
require_once 'src/controllers/reactions/UnReact.php';
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

use Controllers\Blocked\BlockUser;
use Controllers\Blocked\BlockWord;
use Controllers\Blocked\UnblockUser;
use Controllers\Blocked\UnblockWord;
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
use Controllers\Reaction\CreateReaction;
use Controllers\Reaction\UnReact;
use Controllers\Reactions\AddReaction;
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

			writeLog('HOME-PAGE');
			break;

		case 'getFeed':
			redirect_if_method_not('GET', '/');
			$posts = (new GetFeed())->execute($connected_user);
			writeLog('FEED-PAGE');

			global $post;
			foreach ($posts as $post) require 'templates/components/post-feed.php';

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
			writeLog('POST-PAGE', "[POST-ID:{$_GET['id']}]");

			global $trends;
			$trends = (new GetTrends())->execute();
			(new PostPage())->execute($_GET);
			break;

		case 'create':
			if ($method === 'GET') {
				writeLog('CREATE-PAGE');
				(new AuthentificationPage())->execute();
			} else {
				writeLog('CREATE-USER', "[USER-USERNAME:{$_POST['username']}] [USER-EMAIL:{$_POST['email']}]");
				(new CreateUser())->execute($_POST);
			}
			break;

		case 'login':
			redirect_if_method_not('POST', '/');
			writeLog('LOGIN-USER', "[USER:{$_POST['email']}]");

			(new LoginUser())->execute($_POST);
			break;

		case 'logout':
			writeLog('LOGOUT-USER', "[USER-NAME:$connected_user->username] [USER-EMAIL:$connected_user->email]");
			session_destroy();
			redirect('/');

		case 'chat':
			redirect_if_method_not('POST', '/');
			$has_image = strlen($_FILES['image-content']['tmp_name']) > 0;
			$has_image_str = $has_image ? 'true' : 'false';
			writeLog('ADD-POST', "[USER:$connected_user->username] [POST-CONTENT:{$_POST['content']}, POST-IMAGE:$has_image_str]");

			(new AddPost())->execute($connected_user, $_POST);
			break;

		case 'comment':
			redirect_if_method_not('POST', '/');
			writeLog('ADD-COMMENT', "[USER:$connected_user->username] [COMMENT-CONTENT:{$_POST['content']}]");

			(new AddComment())->execute($connected_user, $_POST);
			break;

		case 'delete':
			redirect_if_method_not('POST', '/');
			$type = strtoupper($_GET['type']);
			$id = match ($type) {
				'POST', 'REACTION' => $_POST['post_id'],
				'COMMENT' => $_POST['comment_id'],
				'USER' => $connected_user->id,
				default => null
			};
			writeLog("DELETE-$type", "[$type-ID:$id]");

			(new Delete())->execute($connected_user, $_POST, $type);
			break;

		case 'create-reaction':
			redirect_if_method_not('GET', '/');
			writeLog('ADD-REACTION', "[USER:$connected_user->username] [POST-ID:{$_GET['post-id']}] [EMOJI:{$_GET['emoji']}]");

			(new CreateReaction())->execute($connected_user, $_GET);
			break;

		case 'options':
			writeLog('OPTIONS-PAGE');
			(new OptionsPage())->execute();
			break;

		case 'update-preferences':
			redirect_if_method_not('POST', '/options');
			writeLog('UPDATE-PREFERENCES');

			(new UpdatePreferences())->execute($connected_user, $_POST);
			break;

		case 'update-password':
			redirect_if_method_not('POST', '/options');
			writeLog('UPDATE-PASSWORD');

			(new UpdatePassword())->execute($connected_user, $_POST);
			break;

		case 'update-user-information':
			redirect_if_method_not('POST', '/options');
			writeLog('UPDATE-INFORMATIONS');

			(new UpdateUserInformation())->execute($connected_user, $_POST);
			break;

		case 'friends':
			redirect_if_method_not('GET', '/');
			writeLog('FRIENDS-PAGE');


			(new FriendPage())->execute();
			break;

		case 'send-friend-request':
			redirect_if_method_not('POST', '/');
			writeLog('SEND-FRIEND-REQUEST', "[FROM-USER-ID:$connected_user->id] [TO-USER-ID:{$_POST['requested_id']}]");

			(new SendRequest())->execute($connected_user, $_POST);
			break;

		case 'remove-friend':
			redirect_if_method_not('POST', '/');
			writeLog('REMOVE-FRIEND', "[USER-ID:$connected_user->id] [REMOVED-USER-ID:{$_POST['friend_id']}]");

			(new RemoveFriend())->execute($connected_user, $_POST);
			break;

		case 'accept-friend':
			redirect_if_method_not('POST', '/');
			writeLog('ACCEPT-FRIEND', "[USER-ID:$connected_user->id] [ACCEPTED-USER-ID:{$_POST['requester_id']}]");

			(new AcceptRequest())->execute($connected_user, $_POST);
			break;

		case'decline-friend':
			redirect_if_method_not('POST', '/');
			writeLog('DECLINE-FRIEND', "[USER-ID:$connected_user->id] [DECLINED-USER-ID:{$_POST['requester_id']}]");

			(new DeclineRequest())->execute($connected_user, $_POST);
			break;

		case 'cancel-friend':
			redirect_if_method_not('POST', '/');
			writeLog('CANCEL-FRIEND', "[USER-ID:$connected_user->id] [CANCELED-USER-ID:{$_POST['requested_id']}]");

			(new CancelRequest())->execute($connected_user, $_POST);
			break;

		case 'search-trend':
			redirect_if_method_not('GET', '/');
			global $searched_trend, $trends;
			$searched_trend = $_GET['trend'];
			$trends = (new GetTrends())->execute();
			writeLog('SEARCH-TREND-PAGE', "[TREND:$searched_trend]");
			if (isset($trends[$searched_trend])) (new SearchTrendPage())->execute();
			else redirect('/');
			break;

		case 'profile':
			redirect_if_method_not('GET', '/');

			if ($second_segment === null) redirect("/profile/$connected_user->username");
			$user = (new GetUserByUsername())->execute($second_segment);
			if ($user === null) redirect('/');

			writeLog('PROFILE-PAGE', "[USERNAME:$user->username] [USER-ID:$user->id]");
			if (isset($_GET['offset'])) {
				$user_posts = (new GetPostsByUser())->execute($user->id);
				global $post;
				foreach ($user_posts as $post) require 'templates/components/post-feed.php';
				exit();
			}

			(new ProfilePage())->execute();
			break;

		case 'block-user':
			redirect_if_method_not('POST', '/');
			writeLog('BLOCK-USER', "[USER-ID:$connected_user->id] [BLOCKED-USER-ID:{$_POST['blocked_id']}]");

			(new BlockUser())->execute($connected_user, $_POST);
			break;

		case 'unblock-user':
			redirect_if_method_not('POST', '/');
			writeLog('UNBLOCK-USER', "[USER-ID:$connected_user->id] [UNBLOCKED-USER-ID:{$_POST['blocked_id']}]");

			(new UnblockUser())->execute($connected_user, $_POST);
			break;

		case 'block-word':
			redirect_if_method_not('POST', '/');
			writeLog('BLOCK-WORD', "[USER-ID:$connected_user->id] [BLOCKED-WORD:{$_POST['blocked_word']}]");
			(new BlockWord())->execute($connected_user, $_POST);
			break;

		case 'unblock-word':
			redirect_if_method_not('POST', '/');
			writeLog('UNBLOCK-WORD', "[USER-ID:$connected_user->id] [UNBLOCKED-WORD:{$_POST['blocked-word']}]");
			(new UnblockWord())->execute($connected_user, $_POST);
			break;

		case 'up-vote':
			redirect_if_method_not('POST', '/');
			writeLog('UP-VOTE', "[USER-ID:$connected_user->id] [COMMENT-ID:{$_POST['comment-id']}]");

			(new UpVoteComment())->execute($connected_user, $_POST);
			break;

		case 'un-vote':
			redirect_if_method_not('POST', '/');
			writeLog('UN-VOTE', "[USER-ID:$connected_user->id] [COMMENT-ID:{$_POST['comment-id']}]");

			(new UnVoteComment())->execute($connected_user, $_POST);
			break;

		case 'down-vote':
			redirect_if_method_not('POST', '/');
			writeLog('DOWN-VOTE', "[USER-ID:$connected_user->id] [COMMENT-ID:{$_POST['comment-id']}]");

			(new DownVoteComment())->execute($connected_user, $_POST);
			break;

		case 'react':
			redirect_if_method_not('POST', '/');
			writeLog('REACT', "[USER-ID:$connected_user->id] [REACTION:{$_GET['id']}]");

			(new AddReaction())->execute($connected_user, (float)$_GET['id']);
			redirect($_SERVER['HTTP_REFERER']);

		case 'un-react':
			redirect_if_method_not('POST', '/');
			writeLog('UN-REACT', "[USER-ID:$connected_user->id] [REACTION:{$_GET['id']}]");

			(new UnReact())->execute($connected_user, (float)$_GET['id']);
			redirect($_SERVER['HTTP_REFERER']);
	}
} catch (Throwable $exception) {
	echo '<pre>';
	$exception_type = $exception::class;
	echo "$exception_type: {$exception->getMessage()}<br>";
	echo "{$exception->getTraceAsString()}<br>";
	$previous = $exception->getPrevious();

	while ($previous !== null) {
		echo '<br>Previous: ' . $previous->getMessage();
		$previous = $previous->getPrevious();
	}
	echo '</pre>';
}
