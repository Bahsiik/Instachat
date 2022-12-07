<?php

namespace Src\Controllers\Friends;

use Src\Models\FriendRepository;
use Src\Models\User;

class GetFriendRequests {
	public function execute(User $connected_user): array {
		return (new FriendRepository())->getFriendRequests($connected_user->id);
	}
}
