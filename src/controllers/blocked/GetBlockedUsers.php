<?php

namespace Controllers\Friend;

use Model\BlockedRepository;
use Model\User;

class GetBlockedUsers {
	public function execute(User $connected_user): array {
		$friendRepository = new BlockedRepository();
		return $friendRepository->getBlockedUsers($connected_user->id);
	}
}