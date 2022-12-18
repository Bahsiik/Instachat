<?php
declare(strict_types=1);

namespace Controllers\Pages;


use Controllers\Posts\GetPostContaining;
use function Lib\Utils\filter_blocked_posts;

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
		global $connected_user, $posts;

		$posts = (new GetPostContaining())->execute($_GET['trend']);

		$posts = filter_blocked_posts($connected_user, $posts);

		require_once 'templates/search-trend.php';
	}
}
