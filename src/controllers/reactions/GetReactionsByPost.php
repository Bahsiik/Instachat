<?php
declare(strict_types=1);

namespace Src\Controllers\Reactions;

use Models\Reaction;
use Models\ReactionsRepository;

/**
 * Class GetReactionsByPost is a controller that gets the reactions of a post
 * @package Controllers\Reactions
 */
class GetReactionsByPost {
	/**
	 * execute is the function that gets the reactions of a post
	 * @param float $post_id - the id of the post
	 * @return Array<Reaction> - the reactions of the post
	 */
	public function execute(float $post_id): array {
		return (new ReactionsRepository())->getReactionsByPostId($post_id);
	}
}
