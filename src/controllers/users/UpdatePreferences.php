<?php
declare(strict_types=1);

namespace Controllers\Users;

use Lib\UserException;
use Models\Background;
use Models\Color;
use Models\User;
use Models\UserRepository;
use function Lib\Utils\redirect;

/**
 * Class UpdatePreferences is a controller that updates the preferences of a user
 * @package Controllers\Users
 */
class UpdatePreferences {
	/**
	 * execute is the function that updates the preferences of a user
	 * @param User $connected_user - the user to update
	 * @param array $input - the input of the request
	 * @return void - redirects to the home page
	 */
	public function execute(User $connected_user, array $input): void {
		$background = $input['background'] ?? throw new UserException('Couleur de fond manquante', 2);
		$color = $input['color'] ?? throw new UserException('Thème de couleur manquant', 2);

		$new_user = clone $connected_user;
		$new_user->background = Background::fromInt((int)$background);
		$new_user->color = Color::fromInt((int)$color);
		(new UserRepository())->updateUser($new_user);

		redirect('/options');
	}
}
