<?php
declare(strict_types=1);

namespace Controllers\Friend;

use Model\FriendRepository;
use Model\User;
use RuntimeException;
use function Lib\Utils\redirect;

class DeclineRequest {
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['requester_id'])) throw new RuntimeException('Invalid input');
		(new FriendRepository())->rejectRequest((float)$input['requester_id'], $connected_user->id);
		redirect('/friends');
	}
}
