<?php

namespace Controllers\Pages;

use Models\PostRepository;
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
		global $post_reactions_list;
		$post_id = $input['id'];
		if ($post_id === null) redirect('/');
		$post_reactions_list = (new GetReactionsByPost())->execute((float)$post_id);

		global $post;
		$post = (new PostRepository())->getPost($post_id);

		require_once 'templates/post.php';
	}
}
