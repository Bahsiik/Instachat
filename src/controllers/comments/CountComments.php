<?php
declare(strict_types=1);

namespace Controllers\comments;

use Models\CommentRepository;

class CountComments {
	/**
	 * @return int
	 */
	public function execute(float $post_id): int {
		return (new CommentRepository())->countCommentsByPost($post_id);
	}
}
