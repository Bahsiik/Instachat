<?php

namespace Src\Controllers\Blocked;

use Src\Models\BlockedRepository;
use Src\Models\User;

class GetBlockedUsers {
	public function execute(User $connected_user): array {
		$friendRepository = new BlockedRepository();
		return $friendRepository->getBlockedUsers($connected_user->id);
	}
}
