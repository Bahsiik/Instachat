<?php
declare(strict_types=1);

namespace Controllers\Friends;

use Models\FriendRepository;
use Models\User;
use RuntimeException;
use function Lib\Utils\redirect;

class SendRequest {
	public function execute(User $connected_user, array $input, string $redirect): void {
		if (!isset($input['requested_id'])) throw new RuntimeException('Invalid input');
		(new FriendRepository())->sendRequest($connected_user->id, (float)$input['requested_id']);
		redirect($redirect);
	}
}
