<?php
declare(strict_types=1);

namespace Controllers\Friends;

use Models\FriendRepository;
use Models\User;
use RuntimeException;
use function Lib\Utils\redirect;

/**
 * Class AcceptRequest is a controller that accepts a friend request
 * @package Controllers\Friends
 */
class CancelRequest {
	/**
	 * execute is the function that cancels a friend request
	 * @param User $connected_user - the user that cancels the friend request
	 * @param array $input - the data of the friend request
	 * @return void - redirects to the user page
	 */
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['requested_id'])) throw new RuntimeException('Invalid input');
		(new FriendRepository())->cancelRequest($connected_user->id, (float)$input['requested_id']);
		redirect($input['redirect']);
	}
}
