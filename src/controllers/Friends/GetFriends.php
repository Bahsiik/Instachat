<?php

namespace Src\Controllers\Friends;

use Src\Models\FriendRepository;
use Src\Models\User;

class GetFriends {
	public function execute(User $connected_user): array {
		return (new FriendRepository())->getFriends($connected_user->id);
	}
}
