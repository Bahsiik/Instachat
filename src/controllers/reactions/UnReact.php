<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Models\ReactionsRepository;
use Models\User;
use function Lib\Utils\redirect;

/**
 * Class UnReact is a controller that deletes a reaction
 * @package Controllers\Reactions
 */
class UnReact {
	/**
	 * execute is the function that adds a reaction to a post
	 * @param User $connected_user - the user that adds the reaction
	 * @param float $id - the id of the post
	 * @return void - redirects to the post page
	 */
	public function execute(User $connected_user, float $id): void {
		(new ReactionsRepository())->removeUserReaction($id, $connected_user->id);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
