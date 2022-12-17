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
		require_once 'templates/register.php';
	}
}
