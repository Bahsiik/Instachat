<?php

namespace Controllers\Friend;

use Model\BlockedRepository;
use Model\User;

class GetBlockedWords {
	public function execute(User $connected_user): array {
		$friendRepository = new BlockedRepository();
		return $friendRepository->getBlockedWords($connected_user->id);
	}
}