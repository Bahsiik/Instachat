<?php

namespace Controllers\Blocked;

use Models\BlockedRepository;
use Models\User;
use RuntimeException;
use function Lib\Utils\redirect;

class IsBlocked {
	public function execute(float $blocker_id, float $blocked_id): bool {
		return (new BlockedRepository())->isBlocked($blocker_id, $blocked_id);
	}
}