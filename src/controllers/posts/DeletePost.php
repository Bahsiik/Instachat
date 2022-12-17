<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Models\Post;
use Models\PostRepository;
use function Lib\Utils\redirect;

/**
 * Class DeletePost is a controller that deletes a post
 * @package Controllers\Posts
 */
class DeletePost {
	/**
	 * execute is the function that deletes a post
	 * @param Post|float $post - the post to delete
	 * @return void - redirects to the home page
	 */
	public function execute(Post|float $post): void {
		$post_id = $post instanceof Post ? $post->id : $post;
		(new PostRepository())->deletePost($post_id);
		redirect('/');
	}
}
