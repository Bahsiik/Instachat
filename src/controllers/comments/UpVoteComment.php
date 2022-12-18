<?php
declare(strict_types=1);

namespace Controllers\comments;

use Lib\UserException;
use Models\CommentRepository;
use Models\User;
use VotesRepository;
use function Lib\Utils\redirect;

/**
 * Class UpVoteComment is a controller that upvotes a comment
 * @package Controllers\comments
 */
class UpVoteComment {
	/**
	 * execute is the function that upvotes a comment
	 * @param User $user - the user that upvotes the comment
	 * @param array $input - the data of the comment
	 * @return void - redirects to the comment page
	 */
	public function execute(User $user, array $input): void {
		$comment_id = isset($input['comment-id']) ? (float)$input['comment-id'] : throw new UserException('Le commentaire est invalide ou manquant');
		$votes_repository = new VotesRepository();
		$votes_repository->removeVote($comment_id, $user->id);
		$votes_repository->addVote($comment_id, $user->id, true);

		$comment = (new CommentRepository())->getCommentById($comment_id);
		if (!$comment) redirect('/');

		redirect($_SERVER['HTTP_REFERER']);
	}
}
