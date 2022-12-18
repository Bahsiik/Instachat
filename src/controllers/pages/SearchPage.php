<?php
declare(strict_types=1);

namespace Controllers\Pages;

use Controllers\posts\GetPostsBySearch;
use Controllers\Posts\GetTrends;
use Controllers\users\GetUsersBySearch;

require_once 'src/controllers/users/GetUsersBySearch.php';
require_once 'src/controllers/posts/GetPostsBySearch.php';
require_once 'src/controllers/posts/GetTrends.php';

class SearchPage {
	public function execute() {
		global $input_searched, $posts_searched, $users_searched, $trends;
		$input_searched = $_GET['q'];

		$posts_searched = (new GetPostsBySearch())->execute($input_searched);
		$users_searched = (new GetUsersBySearch())->execute($input_searched);
		$trends = (new GetTrends())->execute();

		require_once 'templates/search.php';
	}
}