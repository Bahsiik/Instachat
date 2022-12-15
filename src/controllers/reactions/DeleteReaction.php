<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Models\ReactionsRepository;
use Models\User;

class DeleteReaction {
	public function execute(User $connected_user, float $reaction_id): void {
		(new ReactionsRepository())->removeUserReaction($reaction_id, $connected_user->id);
	}
}
