<?php

namespace Controllers\Pages;

use Model\User;

class OptionsPage {
	public function execute(User $current_user): void {
		require_once('templates/options.php');
	}
}