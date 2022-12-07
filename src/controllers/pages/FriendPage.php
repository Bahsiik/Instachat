<?php

namespace Src\Controllers\Pages;

use Src\Models\User;

class FriendPage {
	public function execute(User $connected_user): void {
		require_once('templates/friends.php');
	}
}
