<?php
declare(strict_types=1);

namespace Controllers\Friends;

use Models\FriendRepository;
use Models\User;

/**
 * Class GetSentRequests is a controller that gets the sent friend requests of a user
 * @package Controllers\Friends
 */
class GetSentRequests {
	/**
	 * execute is the function that gets the sent friend requests of a user
	 * @param User $connected_user - the user that gets the sent friend requests
	 * @return array - the sent friend requests of the user
	 */
	public function execute(User $connected_user): array {
		return (new FriendRepository())->getSentRequests($connected_user->id);
	}
}
