<?php
declare(strict_types=1);

namespace Controllers\Users;

use Lib\UserException;
use Models\User;
use Models\UserRepository;
use Utils\Blob;
use function Lib\Utils\redirect;

/**
 * Class UpdateAvatar is a controller that updates the avatar of a user
 * @package Controllers\Users
 */
class UpdateAvatar {
	/**
	 * execute is the function that updates the avatar of a user
	 * @param User $connected_user - the user to update
	 * @param array $input - the input of the request
	 * @return void - redirects to the home page
	 */
	public function execute(User $connected_user, array $input): void {
		$image = $_FILES['avatar'];
		if (!isset($image['tmp_name']) || $image['tmp_name'] === '') throw new UserException('Image non valide.');

		$image_tmp = $image['tmp_name'];
		$image_base64 = base64_encode(file_get_contents($image_tmp));
		$image_extension = pathinfo($image['name'], PATHINFO_EXTENSION);
		$image = "data:image/$image_extension;base64,$image_base64";
		if (!in_array($image_extension, ['png', 'jpeg', 'jpg'])) throw new UserException("Format d'image non valide.");

		$new_user = clone $connected_user;
		$new_user->avatar = new Blob($image);

		(new UserRepository())->updateUser($new_user);
		redirect("/profile/$connected_user->username");
	}
}
