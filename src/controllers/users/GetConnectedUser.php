<?php
declare(strict_types=1);

namespace Controllers\Users;

require_once 'src/models/User.php';

use Models\User;
use Models\UserRepository;

/**
 * Class GetConnectedUser is a controller that gets the connected user
 * @package Controllers\Users
 */
class GetConnectedUser {
	/**
	 * execute is the function that gets the connected user
	 * @param array $input - the input of the request
	 * @return ?User - the connected user or null if not connected
	 */
	public function execute(array $input): ?User {
		return (new UserRepository())->getUserById($input['user_id'] ?? -1);
	}
}
