<?php
declare(strict_types=1);

namespace Controllers\comments;

use Vote;
use VotesRepository;

class GetCommentVotes {
	/**
	 * @param float $comment_id
	 * @return Array<Vote>
	 */
	public function execute(float $comment_id): array {
		return (new VotesRepository())->getVotesByCommentId($comment_id);
	}
}
