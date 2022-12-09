<?php
declare(strict_types=1);

namespace Controllers\Friends;

use Models\FriendRepository;
use Models\User;

class GetFriendRequests {
	public function execute(User $connected_user): array {
		return (new FriendRepository())->getFriendRequests($connected_user->id);
	}
}
