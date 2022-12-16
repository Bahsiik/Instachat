<?php
declare(strict_types=1);

namespace Controllers\Pages;

require_once 'src/controllers/blocked/GetBlockedUsers.php';
require_once 'src/controllers/blocked/GetBlockedWords.php';

use Controllers\Blocked\GetBlockedUsers;
use Controllers\Blocked\GetBlockedWords;

class OptionsPage {
	public function execute(): void {
		global $connected_user, $blocked_users, $blocked_words;
		$blocked_users = (new GetBlockedUsers())->execute($connected_user);
		$blocked_words = (new GetBlockedWords())->execute($connected_user);
		require_once 'templates/options.php';
	}
}
