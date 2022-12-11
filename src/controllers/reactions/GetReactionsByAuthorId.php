<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Models\ReactionsRepository;

require_once('src/models/Reaction.php');

class GetReactionsByAuthorId {
	/**
	 * @param float $author_id
	 * @return array
	 */
	public function execute(float $author_id): array {
		return (new ReactionsRepository())->getReactionsByAuthorId($author_id);
	}
}