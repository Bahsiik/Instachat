<?php
declare(strict_types=1);

namespace Controllers\Pages;

require_once 'src/controllers/blocked/GetBlockedUsers.php';
require_once 'src/controllers/blocked/GetBlockedWords.php';

use Controllers\Blocked\GetBlockedUsers;
use Controllers\Blocked\GetBlockedWords;

/**
 * Class OptionsPage is a controller that displays the options page
 * @package Controllers\Pages
 */
class OptionsPage {
	/**
	 * execute is the function that displays the options page
	 * @return void - the options page
	 */
	public function execute(): void {
		global $blocked_users, $blocked_words, $connected_user, $user_delete_error, $user_error, $user_info_error, $user_password_error, $user_preferences_error;
		$blocked_users = (new GetBlockedUsers())->execute($connected_user);
		$blocked_words = (new GetBlockedWords())->execute($connected_user);

		switch ($user_error?->getCode()) {
			case 0:
				$user_info_error = $user_error?->getMessage();
				break;
			case 1:
				$user_password_error = $user_error?->getMessage();
				break;
			case 3:
				$user_preferences_error = $user_error?->getMessage();
				break;
			case 5:
				$user_delete_error = $user_error?->getMessage();
				break;
		}

		require_once 'templates/options.php';
	}
}
