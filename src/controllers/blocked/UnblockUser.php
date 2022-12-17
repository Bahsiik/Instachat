<?php
declare(strict_types=1);

namespace Controllers\Blocked;

use Models\BlockedRepository;
use Models\User;
use RuntimeException;
use function Lib\Utils\redirect;

/**
 * Class UnblockUser is a controller that unblocks a user
 * @package Controllers\Blocked
 */
class UnblockUser {
	/**
	 * execute is the function that unblocks a user
	 * @param User $connected_user - the user that unblocks the other user
	 * @param array $input - the data of the user to unblock
	 * @return void - redirects to the user page
	 */
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['blocked_id'])) throw new RuntimeException('Invalid input');
		(new BlockedRepository())->unblockUser($connected_user->id, (float)$input['blocked_id']);
		redirect($input['redirect']);
	}
}
