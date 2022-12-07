<?php

namespace Src\Controllers\Friends;

use Src\Models\FriendRepository;
use Src\Models\User;

class GetSentRequests {
	public function execute(User $connected_user): array {
		return (new FriendRepository())->getSentRequests($connected_user->id);
	}
}
