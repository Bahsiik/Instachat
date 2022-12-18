<?php
declare(strict_types=1);

namespace Controllers\Blocked;

use Models\BlockedRepository;
use Models\User;

/**
 * Class GetBlockers is a controller that gets the users that blocked a user
 */
class GetBlockers {
	/**
	 * execute is the function that gets the blockers of a user
	 * @param User $connected_user - the user that is blocked
	 * @return array - the blockers
	 */
	public function execute(User $connected_user): array {
		return (new BlockedRepository())->getBlockers($connected_user->id);
	}
}