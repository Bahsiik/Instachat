<?php

namespace Controllers\Friend;

use Model\FriendRepository;
use Model\User;

class GetFriendRequests {
	public function execute(User $connected_user): array {
		$friendRepository = new FriendRepository();
		return $friendRepository->getFriendRequests($connected_user->id);
	}
}