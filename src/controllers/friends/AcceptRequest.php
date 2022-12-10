<?php
declare(strict_types=1);

namespace Controllers\Friends;

use Models\FriendRepository;
use Models\User;
use RuntimeException;
use function Lib\Utils\redirect;

class AcceptRequest {
	public function execute(User $connected_user, array $input, string $redirect): void {
		if (!isset($input['requester_id'])) throw new RuntimeException('Invalid input');
		(new FriendRepository())->acceptRequest((float)$input['requester_id'], $connected_user->id);
		redirect($redirect);
	}
}
