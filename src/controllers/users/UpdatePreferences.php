<?php
declare(strict_types=1);

namespace Controllers\Users;

use Models\Background;
use Models\Color;
use Models\FontSize;
use Models\User;
use Models\UserRepository;
use RuntimeException;
use function Lib\Utils\redirect;

class UpdatePreferences {
	public function execute(User $connected_user, array $input): void {
		$background = $input['background'] ?? throw new RuntimeException('Invalid input');
		$color = $input['color'] ?? throw new RuntimeException('Invalid input');
		$font_size = $input['font-size'] ?? throw new RuntimeException('Invalid input');

		$new_user = clone $connected_user;
		$new_user->background = Background::fromInt((int)$background);
		$new_user->color = Color::fromInt((int)$color);
		$new_user->fontSize = FontSize::fromInt((int)$font_size);
		(new UserRepository())->updateUser($new_user);

		redirect('/options');
	}
}
