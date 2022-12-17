<?php

namespace Controllers\Pages;

use Controllers\Blocked\IsBlocked;
use Models\PostRepository;
use Models\UserRepository;
use Src\Controllers\Reactions\GetReactionsByPost;
use function Lib\Utils\redirect;

/**
 * Class PostPage is a controller that gets the data of a post
 * @package Controllers\Pages
 */
class PostPage {
	/**
	 * execute is the function that gets the data of a post
	 * @param array $input - the data of the post
	 * @return void - redirects to the post page
	 */
	public function execute(array $input): void {
		$post_id = $input['id'];
		if ($post_id === null) redirect('/');

		global $connected_user, $post, $post_reactions_list, $post_author, $is_connected_user_blocked, $is_user_blocked;
		$post = (new PostRepository())->getPost($post_id);
		$post_reactions_list = (new GetReactionsByPost())->execute((float)$post_id);
		$post_author = (new UserRepository())->getUserById($post->authorId);
		$is_connected_user_blocked = (new IsBlocked())->execute($post->authorId, $connected_user->id);
		$is_user_blocked = (new IsBlocked())->execute($connected_user->id, $post->authorId);

		if ($is_connected_user_blocked || $is_user_blocked) redirect('/profile/' . $post_author->username);

		require_once 'templates/post.php';
	}
}
