<?php
declare(strict_types=1);

namespace Controllers\Pages;

/**
 * Class AuthentificationPage is a controller that displays the authentification page
 * @package Controllers\Pages
 */
class AuthentificationPage {
	/**
	 * execute is the function that displays the authentification page
	 * @return void - the authentification page
	 */
	public function execute(): void {
		global $user_error;
		if ($user_error?->getCode() === 0) {
			global $login_error;
			$login_error = $user_error->getMessage();
		} else if ($user_error?->getCode() === 1) {
			global $register_error;
			$register_error = $user_error->getMessage();
		}
		require_once 'templates/register.php';
	}
}
