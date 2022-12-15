<?php
declare(strict_types=1);

namespace Controllers\Reactions;

use Models\ReactionsRepository;
use Models\User;
use function Lib\Utils\redirect;

class AddReaction {
	public function execute(User $connected_user, float $id): void {
		(new ReactionsRepository())->addUserReaction($id, $connected_user->id);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
