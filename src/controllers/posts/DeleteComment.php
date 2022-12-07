<?php
declare(strict_types=1);

namespace Src\Controllers\Post;

use Src\Models\Comment;
use Src\Models\CommentRepository;

class DeleteComment {
	public function execute(Comment|float $comment): void {
		$comment_id = $comment instanceof Comment ? $comment->id : $comment;
		(new CommentRepository())->deleteCommentById($comment_id);
	}
}
