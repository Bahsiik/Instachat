<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Models\ReactionsRepository;
use Models\User;

class RemoveReaction {
	public function execute(User $connected_user, array $input): bool {
		$post_id = $input['post_id'];
		$emoji = $input['emoji'];
		return (new ReactionsRepository())->deleteReaction($post_id, $connected_user->id, $emoji);
	}
}
