<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Models\Reaction;
use Models\ReactionsRepository;

/**
 * Class GetReactionsByAuthor is a controller that gets the reactions of a user
 * @package Controllers\Reactions
 */
class GetReactionsByAuthor {
	/**
	 * execute is the function that gets the reactions of a user
	 * @param float $author_id - the id of the user
	 * @return Array<Reaction> - the reactions of the user
	 */
	public function execute(float $author_id): array {
		return (new ReactionsRepository())->getReactionsByAuthorId($author_id);
	}
}
