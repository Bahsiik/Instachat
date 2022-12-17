<?php
declare(strict_types=1);

namespace Controllers\Posts;

require_once 'src/models/Post.php';

use Models\Post;
use Models\PostRepository;

/**
 * Class GetTrends is a controller that gets the trends
 * @package Controllers\Posts
 */
class GetTrends {
	/**
	 * execute is the function that gets the trends
	 * @return Array<Post> - the trends
	 */
	public function execute(): array {
		return (new PostRepository())->getTrends();
	}
}
