<?php
declare(strict_types=1);

namespace Controllers;

require_once('src/controllers/users/DeleteUser.php');
require_once('src/controllers/posts/DeletePost.php');
require_once('src/controllers/posts/DeleteComment.php');
require_once('src/controllers/reactions/DeleteReaction.php');

use Controllers\Posts\DeleteComment;
use Controllers\Posts\DeletePost;
use Controllers\Reaction\DeleteReaction;
use Controllers\Users\DeleteUser;
use RuntimeException;
use function strtolower;

enum DeleteType: int {
	case POST = 0;
	case COMMENT = 1;
	case USER = 2;
	case REACTION = 3;

	public static function fromName(string $name): ?self {
		$delete_types = self::cases();
		foreach ($delete_types as $delete_type) {
			if (strtolower($delete_type->name) === strtolower($name)) {
				return $delete_type;
			}
		}
		return null;
	}
}

class Delete {
	public function execute(array $input): void {
		$type = DeleteType::fromName($input['type']) ?? throw new RuntimeException('Invalid input');

		switch ($type) {
			case DeleteType::POST:
				$post_id = (float)$input['post_id'];
				(new DeletePost())->execute($post_id);
				break;

			case DeleteType::COMMENT:
				$comment_id = (float)$input['comment_id'];
				(new DeleteComment())->execute($comment_id);
				break;

			case DeleteType::USER:
				global $connected_user;
				(new DeleteUser())->execute($connected_user, $input);
				break;

			case DeleteType::REACTION:
				$post_id = (float)$input['post_id'];
				$user_id = (float)$input['user_id'];
				$emoji = $input['emoji'];
				(new DeleteReaction())->execute($post_id, $user_id, $emoji);
				break;
		}
	}
}
