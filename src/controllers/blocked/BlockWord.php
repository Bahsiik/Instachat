<?php
declare(strict_types=1);

namespace Controllers\Blocked;

use Models\BlockedRepository;
use Models\User;
use RuntimeException;
use function Lib\Utils\redirect;

/**
 * Class BlockWord is a controller that blocks a word
 * @package Controllers\Blocked
 */
class BlockWord {
	/**
	 * execute is the function that blocks a user
	 * @param User $connected_user - the user that blocks the other user
	 * @param array $input - the data of the user to block
	 * @return void - redirects to the user page
	 */
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['blocked-word'])) throw new RuntimeException('Invalid input');
		(new BlockedRepository())->blockWord($connected_user->id, $input['blocked-word']);
		redirect('/options');
	}
}
