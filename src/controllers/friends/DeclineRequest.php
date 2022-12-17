<?php
declare(strict_types=1);

namespace Controllers\Friends;

use Models\FriendRepository;
use Models\User;
use RuntimeException;
use function Lib\Utils\redirect;

/**
 * Class DeclineRequest is a controller that declines a friend request
 * @package Controllers\Friends
 */
class DeclineRequest {
	/**
	 * execute is the function that declines a friend request
	 * @param User $connected_user - the user that declines the friend request
	 * @param array $input - the data of the friend request
	 * @return void - redirects to the user page
	 */
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['requester_id'])) throw new RuntimeException('Invalid input');
		(new FriendRepository())->rejectRequest((float)$input['requester_id'], $connected_user->id);
		redirect($input['redirect']);
	}
}
