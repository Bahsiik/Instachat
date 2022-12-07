<?php

namespace Src\Controllers\Reactions;

use Src\Models\Post;
use Src\Models\ReactionsRepository;
use Src\Models\User;

class DeleteReaction {
	public function execute(Post|float $id, User|float $user, string $emoji): void {
		$post_id = $id instanceof Post ? $id->id : $id;
		$user_id = $user instanceof User ? $user->id : $user;
		(new ReactionsRepository())->deleteReaction($post_id, $user_id, $emoji);
	}
}
