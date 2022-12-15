<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Models\ReactionsRepository;
use Models\User;

class UnReact {
	public function execute(User $connected_user, float $id): bool {
		return (new ReactionsRepository())->removeUserReaction($id, $connected_user->id);
	}
}
