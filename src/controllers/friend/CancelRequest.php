<?php

namespace Controllers\Friend;

use Model\FriendRepository;
use Model\User;
use RuntimeException;
use function Lib\Utils\redirect;

class CancelRequest {
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['requested_id'])) throw new RuntimeException('Invalid input');
		(new FriendRepository())->cancelRequest($connected_user->id, (float)$input['requested_id']);
		redirect('/friends');
	}
}