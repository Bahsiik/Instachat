<?php
declare(strict_types=1);

namespace Controllers\comments;

use Lib\UserException;
use Models\CommentRepository;
use Models\User;
use VotesRepository;
use function Lib\Utils\redirect;

/**
 * Class UnVoteComment is a controller that removes the vote of a comment
 * @package Controllers\comments
 */
class UnVoteComment {
	/**
	 * execute is the function that removes the vote of a comment
	 * @param User $user - the user that removes the vote of the comment
	 * @param array $input - the data of the comment
	 * @return void - redirects to the comment page
	 */
	public function execute(User $user, array $input): void {
		$comment_id = isset($input['comment-id']) ? (float)$input['comment-id'] : throw new UserException('Le commentaire est invalide ou manquant');
		(new VotesRepository())->removeVote($comment_id, $user->id);

		$comment = (new CommentRepository())->getCommentById($comment_id);
		if (!$comment) redirect('/');

		redirect($comment->getLink());
	}
}
