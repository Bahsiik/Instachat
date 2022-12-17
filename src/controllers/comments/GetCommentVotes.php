<?php
declare(strict_types=1);

namespace Controllers\comments;

use Vote;
use VotesRepository;

/**
 * Class GetCommentVotes is a controller that gets the votes of a comment
 * @package Controllers\comments
 */
class GetCommentVotes {
	/**
	 * execute is the function that gets the votes of a comment
	 * @param float $comment_id - the id of the comment
	 * @return Array<Vote> - the votes of the comment
	 */
	public function execute(float $comment_id): array {
		return (new VotesRepository())->getVotesByCommentId($comment_id);
	}
}
