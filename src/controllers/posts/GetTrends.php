<?php
declare(strict_types=1);

namespace Controllers\Posts;

require_once 'src/models/Post.php';

use Controllers\Blocked\GetBlockedWords;
use Models\Post;
use Models\PostRepository;

/**
 * Class GetTrends is a controller that gets the trends
 * @package Controllers\Posts
 */
class GetTrends {
	/**
	 * execute is the function that gets the trends
	 * @return Array<Post> - the trends
	 */
	public function execute(): array {
		global $connected_user, $blocked_words;
		$blocked_words_raw = (new GetBlockedWords())->execute($connected_user);
		$blocked_words = array_map(fn($blocked_word) => $blocked_word->blockedWord, $blocked_words_raw);
		return (new PostRepository())->getTrends($blocked_words);
	}
}
