<?php
declare(strict_types=1);

namespace Controllers\Posts;

require_once 'src/models/Post.php';

use Models\Post;
use Models\PostRepository;

/**
 * Class GetPostContaining is a controller that gets the posts containing a word
 * @package Controllers\Posts
 */
class GetPostContaining {
	/**
	 * execute is the function that gets the posts containing a word
	 * @param string $search - the word to search
	 * @return Array<Post> - the posts containing the word
	 */
	public function execute(string $search): array {
		return (new PostRepository())->getPostContaining($search);
	}
}