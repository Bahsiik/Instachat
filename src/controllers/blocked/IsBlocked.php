<?php

namespace Controllers\Blocked;

use Models\BlockedRepository;

/**
 * Class IsBlocked is a controller that checks if a user is blocked
 * @package Controllers\Blocked
 */
class IsBlocked {
	/**
	 * execute is the function that checks if a user is blocked
	 * @param float $blocker_id - the id of the user that blocks the other user
	 * @param float $blocked_id - the id of the user that is blocked
	 * @return bool - true if the user is blocked, false otherwise
	 */
	public function execute(float $blocker_id, float $blocked_id): bool {
		return (new BlockedRepository())->isBlocked($blocker_id, $blocked_id);
	}
}