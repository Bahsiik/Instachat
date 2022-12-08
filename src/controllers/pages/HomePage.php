<?php

namespace Controllers\Pages;

class HomePage {
	public function execute(): void {
		require_once('templates/homepage.php');
	}
}
