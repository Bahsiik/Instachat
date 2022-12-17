<?php
declare(strict_types=1);

namespace Controllers\Friends;

require_once('src/models/Friend.php');

use Models\FriendRepository;
use Models\User;

/**
 * Class GetFriends is a controller that gets the friends of a user
 * @package Controllers\Friends
 */
class GetFriends {
	/**
	 * execute is the function that gets the friends of a user
	 * @param User $connected_user - the user that gets the friends
	 * @return array - the friends of the user
	 */
	public function execute(User $connected_user): array {
		return (new FriendRepository())->getFriends($connected_user->id);
	}
}
