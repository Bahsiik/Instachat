<?php
declare(strict_types=1);

namespace Src\Controllers\Post;

use Src\Models\Emotion;
use Src\Models\PostRepository;

class UpdateEmotion {
	public function execute(float $id, Emotion $emotion): void {
		(new PostRepository())->updateEmotion($id, $emotion);
	}
}
