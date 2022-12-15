<?php
declare(strict_types=1);

namespace Controllers\comments;

use Models\CommentRepository;
use Models\User;
use function Lib\Utils\redirect;

class AddComment {
	public function execute(User $user, array $input): void {
		$content = $input['content'];
		$post_id = (float)$input['post-id'];
		$reply_to = isset($input['reply-to']) ? (float)$input['reply-to'] : null;
		(new CommentRepository())->addComment($content, $post_id, $user->id, $reply_to);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
