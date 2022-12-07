<?php

namespace Src\Controllers\Pages;

use Src\Models\User;

class OptionsPage {
	public function execute(User $current_user): void {
		require_once('templates/options.php');
	}
}
