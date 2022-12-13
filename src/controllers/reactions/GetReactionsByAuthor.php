<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Models\Reaction;
use Models\ReactionsRepository;

class GetReactionsByAuthor {
	/**
	 * @param float $author_id
	 * @return Array<Reaction>
	 */
	public function execute(float $author_id): array {
		return (new ReactionsRepository())->getReactionsByAuthorId($author_id);
	}
}
