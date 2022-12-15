<?php

namespace Controllers\Pages;

use Models\PostRepository;
use Src\Controllers\Reactions\GetReactionsByPost;
use function Lib\Utils\redirect;

class PostPage {
	public function execute(array $input) {
		global $post_reactions_list;
		$post_id = $input['id'];
		if ($post_id === null) redirect('/');
		$post_reactions_list = (new GetReactionsByPost())->execute((float)$post_id);

		global $post;
		$post = (new PostRepository())->getPost($post_id);

		require_once 'templates/post.php';
	}
}
