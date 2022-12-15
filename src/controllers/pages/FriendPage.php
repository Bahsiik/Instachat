<?php
declare(strict_types=1);

namespace Controllers\Pages;

require_once 'src/controllers/friends/GetFriendRequests.php';
require_once 'src/controllers/friends/GetFriends.php';
require_once 'src/controllers/friends/GetSentRequests.php';
require_once 'src/controllers/posts/GetTrends.php';

use Controllers\Friends\GetFriendRequests;
use Controllers\Friends\GetFriends;
use Controllers\Friends\GetSentRequests;
use Controllers\Posts\GetTrends;

class FriendPage {
	public function execute(): void {
		global $connected_user, $friend_list, $friend_requests, $sent_requests, $trends;
		$friend_list = (new GetFriends())->execute($connected_user);
		$friend_requests = (new GetFriendRequests())->execute($connected_user);
		$sent_requests = (new GetSentRequests())->execute($connected_user);
		$trends = (new GetTrends())->execute();
		require_once('templates/friends.php');
	}
}
