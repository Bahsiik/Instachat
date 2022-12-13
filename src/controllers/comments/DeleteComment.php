<?php
declare(strict_types=1);

namespace Src\Controllers\comments;

use Models\Comment;
use Models\CommentRepository;
use function Lib\Utils\redirect;

class DeleteComment {
	public function execute(Comment $comment): void {
		$comment_id = $comment->id;
		(new CommentRepository())->deleteCommentById($comment_id);
		redirect('/post?id=' . $comment->postId);
	}
}
