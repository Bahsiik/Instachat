<?php
declare(strict_types=1);

namespace Controllers\Users;

use Models\User;
use Models\UserRepository;

require_once 'src/models/User.php';

/**
 * Class GetUser is a controller that gets a user
 * @package Controllers\Users
 */
class GetUser {
	/**
	 * execute is the function that gets a user
	 * @param float $id - the id of the user
	 * @return ?User - the user
	 */
	public function execute(float $id): ?User {
		return (new UserRepository())->getUserById($id);
	}
}
