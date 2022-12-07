<?php
declare(strict_types=1);

namespace Src\Controllers\Post;

use Src\Models\Comment;
use Src\Models\CommentRepository;

class GetComments {
	/**
	 * @return Array<Comment>
	 */
	public function execute(float $post_id): array {
		return (new CommentRepository())->getCommentsByPost($post_id);
	}
}
