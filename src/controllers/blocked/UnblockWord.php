<?php
declare(strict_types=1);

namespace Controllers\Blocked;

use Models\BlockedRepository;
use Models\User;
use RuntimeException;
use function Lib\Utils\redirect;

/**
 * Class UnblockWord is a controller that unblocks a word
 * @package Controllers\Blocked
 */
class UnblockWord {
	/**
	 * execute is the function that unblocks a word
	 * @param User $connected_user - the user that unblocks the other user
	 * @param array $input - the data of the user to unblock
	 * @return void - redirects to the user page
	 */
	public function execute(User $connected_user, array $input): void {
		if (!isset($input['blocked-word'])) throw new RuntimeException('Invalid input');
		(new BlockedRepository())->unblockWord($connected_user->id, $input['blocked-word']);
		redirect('/options');
	}
}