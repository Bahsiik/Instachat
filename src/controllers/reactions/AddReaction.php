<?php
declare(strict_types=1);

namespace Controllers\Reactions;

use Models\ReactionsRepository;
use Models\User;
use function Lib\Utils\redirect;

/**
 * Class AddReaction is a controller that adds a reaction to a post
 * @package Controllers\Reactions
 */
class AddReaction {
	/**
	 * execute is the function that adds a reaction to a post
	 * @param User $connected_user - the user that adds the reaction
	 * @param float $id - the id of the post
	 * @return void - redirects to the post page
	 */
	public function execute(User $connected_user, float $id): void {
		(new ReactionsRepository())->addUserReaction($id, $connected_user->id);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
