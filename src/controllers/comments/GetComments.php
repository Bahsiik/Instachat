<?php
declare(strict_types=1);

namespace Src\Controllers\comments;

use Models\Comment;
use Models\CommentRepository;

class GetComments {
	/**
	 * @return Comment
	 */
	public function execute(float $post_id): array {
		return (new CommentRepository())->getCommentsByPost($post_id);
	}
}
