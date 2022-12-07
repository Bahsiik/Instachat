<?php

namespace Src\Controllers\Friends;

use RuntimeException;
use Src\Models\FriendRepository;
use Src\Models\User;
use function Src\Lib\Utils\redirect;

class AcceptRequest {
	public function execute(User $connected_user, array $input): void {
		$friendRepository = new FriendRepository();
		if (!isset($input['requester_id'])) throw new RuntimeException('Invalid input');
		$friendRepository->acceptRequest($connected_user->id, $input['requester_id']);
		redirect('/friends');
	}
}
