<?php
declare(strict_types=1);

namespace Controllers\Blocked;

use Models\BlockedRepository;
use Models\User;

class GetBlockedUsers {
	public function execute(User $connected_user): array {
		return (new BlockedRepository())->getBlockedUsers($connected_user->id);
	}
}
