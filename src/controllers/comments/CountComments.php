<?php
declare(strict_types=1);

namespace Controllers\comments;

use Models\CommentRepository;

/**
 * Class CountComments is a controller that counts the comments of a post
 * @package Controllers\comments
 */
class CountComments {
	/**
	 * execute is the function that counts the comments of a post
	 * @param float $post_id - the id of the post
	 * @return int - the number of comments of the post
	 */
	public function execute(float $post_id): int {
		return (new CommentRepository())->countCommentsByPost($post_id);
	}
}
