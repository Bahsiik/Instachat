<?php
declare(strict_types=1);

namespace Controllers\Posts;

require_once('src/models/Comment.php');

use Models\Comment;
use Models\CommentRepository;

class GetComments {
	/**
	 * @return Array<Comment>
	 */
	public function execute(float $post_id): array {
		return (new CommentRepository())->getCommentsByPost($post_id);
	}
}
