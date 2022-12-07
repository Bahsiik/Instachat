<?php
declare(strict_types=1);

namespace Src\Controllers\Post;

use RuntimeException;
use Src\Models\PostRepository;
use Src\Models\User;
use function Src\Lib\Utils\redirect;

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
