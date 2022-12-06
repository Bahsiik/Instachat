<?php
declare(strict_types=1);

namespace Controllers\Post;

require_once('src/model/Comment.php');

use Model\Comment;
use Model\CommentRepository;

class GetComments {
	/**
	 * @return Array<Comment>
	 */
	public function execute(int $post_id): array {
		return (new CommentRepository())->getCommentsByPost($post_id);
	}

}