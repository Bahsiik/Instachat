<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Models\ReactionsRepository;
use Models\User;
use function Lib\Utils\redirect;

class CreateReaction {
	public function execute(User $connected_user, array $input): bool {
		$post_id = $input['post-id'];
		$emoji = $input['emoji'];
		(new ReactionsRepository())->createReaction((float)$post_id, $emoji, $connected_user->id);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
