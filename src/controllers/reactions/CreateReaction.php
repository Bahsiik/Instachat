<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Models\ReactionsRepository;
use Models\User;

class CreateReaction {
	public function execute(User $connected_user, string $post_id, string $emoji): bool {
		var_dump($connected_user, $post_id, $emoji);
		return (new ReactionsRepository())->createReaction((float)$post_id, $emoji, $connected_user->id);
	}
}
