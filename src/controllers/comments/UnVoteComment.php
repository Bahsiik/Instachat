<?php
declare(strict_types=1);

namespace Controllers\comments;

use Models\CommentRepository;
use Models\User;
use RuntimeException;
use VotesRepository;
use function Lib\Utils\redirect;

class UnVoteComment {
	public function execute(User $user, array $input): void {
		$comment_id = (float)$input['comment-id'] ?? throw new RuntimeException('Comment id is required');
		(new VotesRepository())->removeVote($comment_id, $user->id);

		$comment = (new CommentRepository())->getCommentById($comment_id);
		if (!$comment) redirect('/');

		redirect($comment->getLink());
	}
}
