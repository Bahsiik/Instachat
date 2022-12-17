<?php
declare(strict_types=1);

namespace Controllers\Friends;

use Lib\UserException;
use Models\FriendRepository;
use Models\User;
use function Lib\Utils\redirect;

/**
 * Class CancelRequest is a controller that cancels a friend request
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
		if (!isset($input['requested_id'])) throw new UserException("L'utilisateur est invalide ou manquant");
		(new FriendRepository())->cancelRequest($connected_user->id, (float)$input['requested_id']);
		redirect($input['redirect']);
	}
}
