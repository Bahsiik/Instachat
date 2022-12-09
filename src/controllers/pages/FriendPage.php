<?php
declare(strict_types=1);

namespace Controllers\Pages;

class FriendPage {
	public function execute(): void {
		require_once('templates/friends.php');
	}
}
