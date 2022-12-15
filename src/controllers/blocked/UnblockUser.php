<?php
declare(strict_types=1);

namespace Controllers\Blocked;

use Models\BlockedRepository;
use Models\User;
use RuntimeException;
use function Lib\Utils\redirect;

class UnblockUser {
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['blocked_id'])) throw new RuntimeException('Invalid input');
		(new BlockedRepository())->unblockUser($connected_user->id, (float)$input['blocked_id']);
		redirect($input['redirect']);
	}
}
