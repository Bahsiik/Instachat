<?php
declare(strict_types=1);

namespace Controllers\User;

use Model\User;
use Model\UserRepository;
use RuntimeException;
use function Lib\Utils\redirect;

class DeleteUser {
	public function execute(User $user, array $input): void {
		$password = $input['password'] ?? throw new RuntimeException('Invalid input');
		$is_valid = (new UserRepository())->checkHash($user->email, $password);
		if (!$is_valid) throw new RuntimeException('Invalid password');

		(new UserRepository())->deleteUserById($user->id);
		redirect('/create');
	}
}
