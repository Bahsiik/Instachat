<?php
declare(strict_types=1);

namespace Controllers\Post;

use Model\Emotion;
use Model\PostRepository;

class UpdateEmotion {
	public function execute(float $id, Emotion $emotion): void {
		(new PostRepository())->updateEmotion($id, $emotion);
	}
}