<?php

namespace Src\Controllers\Users;

use Src\Models\User;
use Src\Models\UserRepository;

class GetUser {
	public function execute(float $id): ?User {
		return (new UserRepository())->getUserById($id);
	}
}
