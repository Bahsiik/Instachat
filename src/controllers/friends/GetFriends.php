<?php
declare(strict_types=1);

namespace Controllers\Friends;

require_once('src/models/Friend.php');

use Models\FriendRepository;
use Models\User;

class GetFriends {
	public function execute(User $connected_user): array {
		return (new FriendRepository())->getFriends($connected_user->id);
	}
}
