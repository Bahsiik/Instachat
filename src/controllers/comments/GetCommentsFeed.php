<?php
declare(strict_types=1);

namespace Src\Controllers\comments;

use Models\Comment;
use Models\CommentRepository;

/**
 * Class GetCommentsFeed is a controller that gets the comments feed
 * @package Src\Controllers\comments
 */
class GetCommentsFeed {
	/**
	 * execute is the function that gets the comments feed
	 * @param float $post_id - the id of the post
	 * @return Array<Comment> - the comments feed
	 */
	public function execute(float $post_id): array {
		$offset = (int)($_GET['offset'] ?? 0);
		return (new CommentRepository())->getCommentsByPost($post_id, $offset);
	}
}
