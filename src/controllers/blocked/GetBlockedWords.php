<?php
declare(strict_types=1);

namespace Controllers\Blocked;

use Model\BlockedRepository;
use Model\User;

class GetBlockedWords {
	public function execute(User $connected_user): array {
		return (new BlockedRepository())->getBlockedWords($connected_user->id);
	}
}
