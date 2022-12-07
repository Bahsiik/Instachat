<?php

namespace Src\Controllers\Friends;

use RuntimeException;
use Src\Models\FriendRepository;
use Src\Models\User;
use function Src\Lib\Utils\redirect;

class SendRequest {
	public function execute(User $connected_user, array $input): void {
		$friendRepository = new FriendRepository();
		if (!isset($input['requested_id'])) throw new RuntimeException('Invalid input');
		$friendRepository->sendRequest($connected_user->id, $input['requested_id']);
		redirect('/friends');
	}
}
