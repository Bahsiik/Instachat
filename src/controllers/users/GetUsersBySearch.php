<?php
declare(strict_types=1);

namespace Controllers\Users;

use Models\UserRepository;

class GetUsersBySearch {

	public function execute(string $input): array {
		return (new UserRepository())->getUsersBySearch($input);
	}
}