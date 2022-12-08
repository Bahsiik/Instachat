<?php

namespace Controllers\Pages;

use Model\User;

class TrendPage {
	public function execute(User $connected_user): void {
		require_once('templates/trends.php');
	}
}