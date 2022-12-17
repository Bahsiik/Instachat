<?php
declare(strict_types=1);

namespace Controllers\Pages;

/**
 * Class HomePage is a controller that displays the home page
 * @package Controllers\Pages
 */
class HomePage {
	/**
	 * execute is the function that displays the home page
	 * @return void - the home page
	 */
	public function execute(): void {
		require_once 'templates/homepage.php';
	}
}
