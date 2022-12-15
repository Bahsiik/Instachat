<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Models\ReactionsRepository;
use Models\User;
use function Lib\Utils\redirect;

class CreateReaction {
	public function execute(User $connected_user, string $post_id, string $emoji): void {
		var_dump($connected_user, $post_id, $emoji);
		(new ReactionsRepository())->createReaction((float)$post_id, $emoji, $connected_user->id);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
