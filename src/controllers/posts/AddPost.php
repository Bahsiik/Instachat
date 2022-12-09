<?php
declare(strict_types=1);

namespace Controllers\Posts;

use Models\PostRepository;
use Models\User;
use RuntimeException;
use function Lib\Utils\redirect;

class AddPost {
	public function execute(User $connected_user, array $input): void {
		$chat = ['content', 'emotion'];
		foreach ($chat as $value) {
			if (!isset($input[$value])) throw new RuntimeException('Invalid input');
		}
		(new PostRepository())->addPost($input['content'], $connected_user->id, $input['photo'] ?? '', (int)$input['emotion']);

		redirect('/');
	}
}
