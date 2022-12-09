<?php
declare(strict_types=1);

namespace Controllers\Pages;

class OptionsPage {
	public function execute(): void {
		require_once('templates/options.php');
	}
}
