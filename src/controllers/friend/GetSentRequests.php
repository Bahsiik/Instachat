<?php
declare(strict_types=1);

namespace Controllers\Friend;

use Model\FriendRepository;
use Model\User;

class GetSentRequests {
	public function execute(User $connected_user): array {
		return (new FriendRepository())->getSentRequests($connected_user->id);
	}
}
