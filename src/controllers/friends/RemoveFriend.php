<?php
declare(strict_types=1);

namespace Controllers\Friends;

use Lib\UserException;
use Models\FriendRepository;
use Models\User;
use function Lib\Utils\redirect;

/**
 * Class RemoveFriend is a controller that removes a friend
 * @package Controllers\Friends
 */
class RemoveFriend {
	/**
	 * execute is the function that removes a friend
	 * @param User $connected_user - the user that removes the friend
	 * @param array $input - the data of the friend
	 * @return void - redirects to the user page
	 */
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['friend_id'])) throw new UserException("L'utilisateur est invalide ou manquant");
		(new FriendRepository())->removeFriend((float)$input['friend_id'], $connected_user->id);
		redirect($input['redirect']);
	}
}
