<?php
declare(strict_types=1);

namespace Src\Controllers\Reactions;

use Models\Reaction;
use Models\ReactionsRepository;

class GetReactionsByPost {
	/**
	 * @param float $post_id
	 * @return Array<Reaction>
	 */
	public function execute(float $post_id): array {
		return (new ReactionsRepository())->getReactionsByPostId($post_id);
	}
}
