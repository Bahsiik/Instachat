<?php
declare(strict_types=1);

namespace Src\Controllers\comments;

use Models\Comment;
use Models\CommentRepository;

class DeleteComment {
	public function execute(Comment|float $comment): void {
		$comment_id = $comment instanceof Comment ? $comment->id : $comment;
		(new CommentRepository())->deleteCommentById($comment_id);
	}
}
