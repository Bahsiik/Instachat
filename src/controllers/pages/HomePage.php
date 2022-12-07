<?php

namespace Src\Controllers\Pages;

class HomePage {
	public function execute(): void {
		require_once('templates/homepage.php');
	}
}
