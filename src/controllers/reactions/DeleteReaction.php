<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Model\Post;
use Model\ReactionsRepository;
use Model\User;

class DeleteReaction {
	public function execute(Post|float $id, User|float $user, string $emoji): void {
		$post_id = $id instanceof Post ? $id->id : $id;
		$user_id = $user instanceof User ? $user->id : $user;
		(new ReactionsRepository())->deleteReaction($post_id, $user_id, $emoji);
	}
}
