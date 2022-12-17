<?php
declare(strict_types=1);

namespace Src\Controllers\comments;

use Models\CommentRepository;
use Models\User;
use RuntimeException;
use VotesRepository;
use function Lib\Utils\redirect;

/**
 * Class DownVoteComment is a controller that downvotes a comment
 * @package Src\Controllers\comments
 */
class DownVoteComment {
	/**
	 * execute is the function that downvotes a comment
	 * @param User $user - the user that downvotes the comment
	 * @param array $input - the data of the comment
	 * @return void - redirects to the comment page
	 */
	public function execute(User $user, array $input): void {
		$comment_id = isset($input['comment-id']) ? (float)$input['comment-id'] : throw new RuntimeException('Comment id is required');
		$votes_repository = new VotesRepository();
		$votes_repository->removeVote($comment_id, $user->id);
		$votes_repository->addVote($comment_id, $user->id, false);

		$comment = (new CommentRepository())->getCommentById($comment_id);
		if (!$comment) redirect('/');

		redirect($comment->getLink());
	}
}
