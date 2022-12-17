<?php
declare(strict_types=1);

namespace Controllers\Blocked;

use Models\BlockedRepository;
use Models\User;

/**
 * Class GetBlockedWords is a controller that gets the blocked words of a user
 * @package Controllers\Blocked
 */
class GetBlockedWords {
	/**
	 * execute is the function that gets the blocked words of a user
	 * @param User $connected_user - the user that blocks the other user
	 * @return array - the blocked words
	 */
	public function execute(User $connected_user): array {
		return (new BlockedRepository())->getBlockedWords($connected_user->id);
	}
}
