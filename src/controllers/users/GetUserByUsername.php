<?php
declare(strict_types=1);

namespace Controllers\Users;

use Models\User;
use Models\UserRepository;

/**
 * Class GetUser is a controller that gets a user
 * @package Controllers\Users
 */
class GetUserByUsername {
	/**
	 * execute is the function that gets a user
	 * @param string $username - the username of the user
	 * @return ?User - the user or null if not found
	 */
	public function execute(string $username): ?User {
		return (new UserRepository())->getUserByUsername($username);
	}
}