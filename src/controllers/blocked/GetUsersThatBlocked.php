<?php

namespace Controllers\Blocked;

use Models\User;
use Models\BlockedRepository;

class GetUsersThatBlocked {
	public function execute(User $user): array {
		return (new BlockedRepository())->getUsersThatBlocked($user->id);
	}
}