<?php
declare(strict_types=1);

namespace Controllers\Pages;

require_once 'src/controllers/blocked/GetBlockedUsers.php';

use Controllers\Blocked\GetBlockedUsers;

class OptionsPage {
	public function execute(): void {
		global $connected_user, $blocked_users;
		$blocked_users = (new GetBlockedUsers())->execute($connected_user);
		require_once('templates/options.php');
	}
}
