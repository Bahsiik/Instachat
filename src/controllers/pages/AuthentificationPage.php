<?php
declare(strict_types=1);

namespace Controllers\Pages;

class AuthentificationPage {
	public function execute(): void {
		require_once 'templates/register.php';
	}
}
