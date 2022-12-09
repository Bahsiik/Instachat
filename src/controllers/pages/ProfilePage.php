<?php

namespace Controllers\Pages;

class ProfilePage {
	public function execute(): void {
		require_once('templates/profile.php');
	}
}