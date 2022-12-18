<?php
declare(strict_types=1);

namespace Controllers\Users;

use Models\UserRepository;

/**
 * Class GetUsersBySearch is a controller that gets the users by a search
 */
class GetUsersBySearch {

	/**
	 * execute is the function that gets the users by a search
	 * @param string $input - the input of the request
	 * @return array - the users
	 */
	public function execute(string $input): array {
		return (new UserRepository())->getUsersBySearch($input);
	}
}