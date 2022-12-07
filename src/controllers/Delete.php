<?php

namespace Controllers;

use Controllers\Post\DeleteComment;
use Controllers\Post\DeletePost;
use Controllers\Reaction\DeleteReaction;
use Controllers\User\DeleteUser;

enum DeleteType: int {
	case POST = 0;
	case COMMENT = 1;
	case USER = 2;
	case REACTION = 3;

	public static function fromName(string $name): self {
		return self::tryFrom(strtolower($name));
	}
}

class Delete {
	public function execute(array $input, DeleteType $type): void {
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
				$user_id = (float)$input['user_id'];
				(new DeleteUser())->execute($user_id);
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
