<?php
declare(strict_types=1);

namespace Src\Controllers\comments;

use Models\Comment;
use Models\CommentRepository;
use function Lib\Utils\redirect;

/**
 * Class DeleteComment is a controller that deletes a comment
 * @package Src\Controllers\comments
 */
class DeleteComment {
	/**
	 * execute is the function that deletes a comment
	 * @param Comment $comment - the comment to delete
	 * @return void - redirects to the post page
	 */
	public function execute(Comment $comment): void {
		$comment_id = $comment->id;
		(new CommentRepository())->deleteCommentById($comment_id);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
