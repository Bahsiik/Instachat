<?php

namespace Src\Controllers\Friends;

use RuntimeException;
use Src\Models\FriendRepository;
use Src\Models\User;
use function Src\Lib\Utils\redirect;

class RemoveFriend {
	public function execute(User $connected_user, array $input): void {
		$friendRepository = new FriendRepository();
		if (!isset($input['friend_id'])) throw new RuntimeException('Invalid input');
		$friendRepository->removeFriend($connected_user->id, $input['friend_id']);
		redirect('/friends');
	}
}
