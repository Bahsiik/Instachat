<?php
declare(strict_types=1);

namespace Controllers\Blocked;

use Models\BlockedRepository;
use Models\User;

/**
 * Class GetBlockedUsers is a controller that gets the blocked users of a user
 * @package Controllers\Blocked
 */
class GetBlockedUsers {
	/**
	 * execute is the function that gets the blocked users of a user
	 * @param User $connected_user - the user that blocks the other user
	 * @return array - the blocked users
	 */
	public function execute(User $connected_user): array {
		return (new BlockedRepository())->getBlockedUsers($connected_user->id);
	}
}
