<?php
declare(strict_types=1);

namespace Controllers\Pages;

class SearchTrendPage {
	public function execute(): void {
		require_once 'templates/searchtrend.php';
	}
}
