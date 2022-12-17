<?php
declare(strict_types=1);

namespace Controllers\Friends;

use Models\FriendRepository;
use Models\User;
use RuntimeException;
use function Lib\Utils\redirect;

/**
 * Class SendRequest is a controller that sends a friend request
 * @package Controllers\Friends
 */
class SendRequest {
	/**
	 * execute is the function that sends a friend request
	 * @param User $connected_user - the user that sends the friend request
	 * @param array $input - the data of the friend
	 * @return void - redirects to the user page
	 */
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['requested_id'])) throw new RuntimeException('Invalid input');
		(new FriendRepository())->sendRequest($connected_user->id, (float)$input['requested_id']);
		redirect($input['redirect']);
	}
}
