<?php
declare(strict_types=1);

namespace Controllers\Reactions;

use Models\ReactionsRepository;

class GetReaction {
	public function execute(float $id): array {
		return (new ReactionsRepository())->getReaction();
	}
}
