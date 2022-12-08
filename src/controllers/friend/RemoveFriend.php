<?php
declare(strict_types=1);

namespace Controllers\Friend;

use Model\FriendRepository;
use Model\User;
use RuntimeException;
use function Lib\Utils\redirect;

class RemoveFriend {
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['friend_id'])) throw new RuntimeException('Invalid input');
		(new FriendRepository())->removeFriend($connected_user->id, $input['friend_id']);
		redirect('/friends');
	}
}
