<?php
declare(strict_types=1);

namespace Controllers\comments;

use Models\CommentRepository;
use Models\User;
use function Lib\Utils\redirect;

/**
 * Class AddComment is a controller that adds a comment to a post
 * @package Controllers\comments
 */
class AddComment {
	/**
	 * execute is the function that adds a comment to a post
	 * @param User $user - the user that adds the comment
	 * @param array $input - the data of the comment
	 * @return void - redirects to the post page
	 */
	public function execute(User $user, array $input): void {
		$content = $input['content'];
		$post_id = (float)$input['post-id'];
		$reply_to = isset($input['reply-to']) ? (float)$input['reply-to'] : null;
		(new CommentRepository())->addComment($content, $post_id, $user->id, $reply_to);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
