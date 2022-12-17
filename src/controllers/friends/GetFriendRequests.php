<?php
declare(strict_types=1);

namespace Controllers\Friends;

use Models\FriendRepository;
use Models\User;

/**
 * Class GetFriendRequests is a controller that gets the friend requests of a user
 * @package Controllers\Friends
 */
class GetFriendRequests {
	/**
	 * execute is the function that gets the friend requests of a user
	 * @param User $connected_user - the user that gets the friend requests
	 * @return array - the friend requests of the user
	 */
	public function execute(User $connected_user): array {
		return (new FriendRepository())->getFriendRequests($connected_user->id);
	}
}
