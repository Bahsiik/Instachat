<?php
declare(strict_types=1);

namespace Controllers\Blocked;

use Lib\UserException;
use Models\BlockedRepository;
use Models\FriendRepository;
use Models\User;
use function Lib\Utils\redirect;

/**
 * Class BlockUser is a controller that blocks a user
 * @package Controllers\Blocked
 */
class BlockUser {
	/**
	 * execute is the function that blocks a user
	 * @param User $connected_user - the user that blocks the other user
	 * @param array $input - the data of the user to block
	 * @return void - redirects to the user page
	 */
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['blocked_id'])) throw new UserException("L'utilisateur est invalide ou manquant");
		(new BlockedRepository())->blockUser($connected_user->id, (float)$input['blocked_id']);
		(new FriendRepository())->removeFriend($connected_user->id, (float)$input['blocked_id']);
		redirect($input['redirect']);
	}
}
