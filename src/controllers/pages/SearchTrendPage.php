<?php
declare(strict_types=1);

namespace Controllers\Pages;

use Controllers\Blocked\GetBlockedUsers;
use Controllers\Posts\GetPostContaining;

require_once 'src/controllers/blocked/GetBlockedUsers.php';
require_once 'src/controllers/posts/GetPostContaining.php';

/**
 * Class SearchTrendPage is a controller that displays the search trend page
 * @package Controllers\Pages
 */
class SearchTrendPage {
	/**
	 * execute is the function that displays the search trend page
	 * @return void - the search trend page
	 */
	public function execute(): void {
		global $connected_user, $searched_posts, $blocked_users;

		$blocked_users = (new GetBlockedUsers())->execute($connected_user);

		$searched_posts = (new GetPostContaining())->execute($_GET['trend']);

		foreach ($searched_posts as $key => $post) {
			foreach ($blocked_users as $blocked_user) {
				if ($post->authorId === $blocked_user->blockedId) {
					unset($searched_posts[$key]);
				}
			}
		}

		require_once 'templates/search-trend.php';
	}
}
