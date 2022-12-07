<?php

namespace Src\Controllers\Blocked;

use RuntimeException;
use Src\Models\BlockedRepository;
use Src\Models\User;

class BlockUser {
	public function execute(User $connected_user, array $input): void {
		$friendRepository = new BlockedRepository();
		if (!isset($input['blocked_id'])) throw new RuntimeException('Invalid input');
		$friendRepository->blockUser($connected_user->id, $input['blocked_id']);
	}
}
