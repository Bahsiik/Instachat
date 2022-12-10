<?php
declare(strict_types=1);

namespace Controllers\Post;

use Models\CommentRepository;
use RuntimeException;

class GetCommentsRecursively {
	public function execute(array $input) {
		$parent_id = $input['parent_id'] ?? throw new RuntimeException('Parent id is required');
		$comments = (new CommentRepository())->getCommentsByReply($input['post_id']);
		$comments = (new GetCommentsRecursively())->execute($comments);
		return $comments;
	}
}
