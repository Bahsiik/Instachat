<?php

namespace Controllers\comments;

use Controllers\Blocked\GetBlockedWords;
use Models\CommentRepository;
use function Lib\Utils\filter_blocked_posts;

/**
 * Class GetCommentsByAuthor is a controller that gets all the comments of an author
 */
class GetCommentsByAuthor {

	/**
	 * execute is the function that gets all the comments of an author
	 * @param float $author_id - the id of the author
	 * @return array - the comments of the author
	 */
	public function execute(float $author_id): array {
		global $connected_user;
		$offset = (int)($_GET['offsetComments'] ?? 0);
		$comments = (new CommentRepository())->getCommentsByAuthor($author_id, $offset);

		return filter_blocked_posts($connected_user, $comments);
	}

}