<?php
declare(strict_types=1);

namespace Controllers\Pages;

class TrendPage {
	public function execute(): void {
		require_once('templates/trends.php');
	}
}
