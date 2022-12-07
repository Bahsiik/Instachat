<?php

namespace Src\Controllers\Blocked;

use Src\Models\BlockedRepository;
use Src\Models\User;

class GetBlockedWords {
	public function execute(User $connected_user): array {
		$friendRepository = new BlockedRepository();
		return $friendRepository->getBlockedWords($connected_user->id);
	}
}
