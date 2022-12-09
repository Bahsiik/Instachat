<?php
declare(strict_types=1);

namespace Controllers\Pages;

class HomePage {
	public function execute(): void {
		require_once('templates/homepage.php');
	}
}
