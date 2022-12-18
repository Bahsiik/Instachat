<?php

namespace Controllers\Blocked;

use Models\User;
use Models\BlockedRepository;

/**
 * Class GetUsersThatBlocked - Get users that blocked the current user
 */
class GetUsersThatBlocked {
	/**
	 * execute - Get users that blocked the current user
	 * @param User $user - Current user
	 * @return array - Users that blocked the current user
	 */
	public function execute(User $user): array {
		return (new BlockedRepository())->getUsersThatBlocked($user->id);
	}
}