<?php
declare(strict_types=1);

namespace Controllers\Post;

use Model\PostRepository;
use Model\User;
use RuntimeException;

class AddPost {
    public function execute(User $connected_user, array $input): void {
        $chat = ['chat'];
        foreach ($chat as $value) {
            if (!isset($input[$value])) throw new RuntimeException('Invalid input');
        }
        (new PostRepository())->addPost($input['content'], $connected_user->id, $input['photo'], $input['emotion']);
    }
}
