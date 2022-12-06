<?php

namespace Controllers\User;

use Model\User;
use Model\UserRepository;

require_once('src/model/User.php');

class GetUser {
	public function execute(float $id): User {
		return (new UserRepository())->getUserById($id);
	}
}