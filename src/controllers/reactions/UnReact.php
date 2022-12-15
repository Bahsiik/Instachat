<?php
declare(strict_types=1);

namespace Controllers\Reaction;

use Models\ReactionsRepository;
use Models\User;
use function Lib\Utils\redirect;

class UnReact {
	public function execute(User $connected_user, float $id): void {
		(new ReactionsRepository())->removeUserReaction($id, $connected_user->id);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
