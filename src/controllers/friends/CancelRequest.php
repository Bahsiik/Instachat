<?php
declare(strict_types=1);

namespace Controllers\Friends;

use Models\FriendRepository;
use Models\User;
use RuntimeException;
use function Lib\Utils\redirect;

class CancelRequest {
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['requested_id'])) throw new RuntimeException('Invalid input');
		(new FriendRepository())->cancelRequest($connected_user->id, (float)$input['requested_id']);
		redirect('/friends');
	}
}
