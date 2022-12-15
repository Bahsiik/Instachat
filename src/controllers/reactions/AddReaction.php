<?php
declare(strict_types=1);

namespace Controllers\Reactions;

use Models\ReactionsRepository;
use Models\User;

class AddReaction {
	public function execute(User $connected_user, float $id): bool {
		return (new ReactionsRepository())->addUserReaction($id, $connected_user->id);
	}
}
