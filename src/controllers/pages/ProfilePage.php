<?php
declare(strict_types=1);

namespace Controllers\Pages;

require_once 'src/controllers/reactions/GetReactionsByAuthor.php';
require_once 'src/controllers/blocked/IsBlocked.php';
require_once 'src/controllers/friends/GetFriends.php';
require_once 'src/controllers/friends/GetFriendRequests.php';
require_once 'src/controllers/friends/GetSentRequests.php';
require_once 'src/controllers/posts/GetPostsByUser.php';
require_once 'src/controllers/posts/GetTrends.php';
require_once 'src/controllers/reactions/GetReactionsByAuthor.php';


use Controllers\Blocked\IsBlocked;
use Controllers\Friends\GetFriendRequests;
use Controllers\Friends\GetFriends;
use Controllers\Friends\GetSentRequests;
use Controllers\Posts\GetPostsByUser;
use Controllers\Posts\GetTrends;
use Controllers\Reaction\GetReactionsByAuthor;

/**
 * Class ProfilePage is a controller that displays the profile page
 * @package Controllers\Pages
 */
class ProfilePage {
	/**
	 * execute is the function that displays the profile page
	 * @return void - the profile page
	 */
	public function execute(): void {
		global $connected_user, $user, $friend_list, $friend_requests, $sent_requests, $user_posts, $is_connected_user_blocked, $is_user_blocked, $friendship, $reactions_list, $trends;

		$friend_list = (new GetFriends())->execute($user);
		$friend_requests = (new GetFriendRequests())->execute($connected_user);
		$sent_requests = (new GetSentRequests())->execute($connected_user);
		$user_posts = (new GetPostsByUser())->execute($user->id);
		$is_connected_user_blocked = (new IsBlocked())->execute($user->id, $connected_user->id);
		$is_user_blocked = (new IsBlocked())->execute($connected_user->id, $user->id);
		$reactions_list = (new GetReactionsByAuthor())->execute($user->id);
		$trends = (new GetTrends())->execute();

		if ($connected_user->id !== $user->id) {
			foreach ($friend_list as $friend) {
				if ($user->id === $friend->requesterId && $connected_user->id === $friend->requestedId || $user->id === $friend->requestedId && $connected_user->id === $friend->requesterId) {
					$friendship = 1;
					break;
				}
			}
			foreach ($friend_requests as $friend) {
				if ($user->id === $friend->requesterId) {
					$friendship = 2;
					break;
				}
			}
			foreach ($sent_requests as $friend) {
				if ($user->id === $friend->requestedId) {
					$friendship = 3;
					break;
				}
			}
		}
		require_once 'templates/profile.php';
	}
}
