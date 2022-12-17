<?php
declare(strict_types=1);

namespace Controllers\Friends;

use Lib\UserException;
use Models\FriendRepository;
use Models\User;
use function Lib\Utils\redirect;

/**
 * Class AcceptRequest is a controller that accepts a friend request
 * @package Controllers\Friends
 */
class AcceptRequest {
	/**
	 * execute is the function that accepts a friend request
	 * @param User $connected_user - the user that accepts the friend request
	 * @param array $input - the data of the friend request
	 * @return void - redirects to the user page
	 */
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['requester_id'])) throw new UserException("L'utilisateur est invalide ou manquant");
		(new FriendRepository())->acceptRequest((float)$input['requester_id'], $connected_user->id);
		redirect($input['redirect']);
	}
}
