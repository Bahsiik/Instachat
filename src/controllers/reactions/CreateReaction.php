<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Models\ReactionsRepository;
use Models\User;
use function Lib\Utils\redirect;

/**
 * Class CreateReaction is a controller that creates a reaction
 * @package Controllers\Reactions
 */
class CreateReaction {
	/**
	 * execute is the function that adds a reaction to a post
	 * @param User $connected_user - the user that adds the reaction
	 * @param array $input - the input of the request
	 * @return void - redirects to the post page
	 */
	public function execute(User $connected_user, array $input): void {
		$post_id = $input['post-id'];
		$emoji = $input['emoji'];
		(new ReactionsRepository())->createReaction((float)$post_id, $emoji, $connected_user->id);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
