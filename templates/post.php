<?php

use Controllers\User\GetUser;
use Model\Emotion;

require_once('src/controllers/user/GetUser.php');

$user_controller = new GetUser();

global $post;
global $comments;
global $connected_user;
$user = $user_controller->execute($post->author_id);
?>
<div class="post-container">
	<div class="post-avatar">
		<img src="<?= $user->displayAvatar($connected_user) ?>" alt="avatar">
	</div>
	<div class="post-right-part">
		<div class="post-info">
			<div class="post-display-name">
				<?= $user->getDisplayOrUsername() ?>
			</div>
			<div class="post-username">
				<?= "@$user->username" ?>
			</div>
			<div class="post-dot-separator">·</div>
			<div class="post-date">
				<?php
				format_date_time($post->creation_date);
				?>
			</div>
			<div class="post-emotion">
				<span class="post-emotion twemoji-load"><?= Emotion::cases()[$post->emotion->value - 1]->display() ?></span>
			</div>
		</div>
		<div class="post-content">
			<?php
			if (isset($post->content)) {
				echo $post->content;
			} ?>
		</div>
		<div class="post-action-buttons">
			<button class="post-comment-btn">
				<span class="material-symbols-outlined post-action-buttons-color">chat_bubble</span>
				<p class="post-comment-count">
					<?php
					if (count($comments) > 0) echo count($comments);
					?>
				</p>
			</button>
			<button class="post-share-btn">
				<span class="material-symbols-outlined post-action-buttons-color">ios_share</span>
			</button>
			<button class="post-reaction-btn">
				<span class="material-symbols-outlined post-action-buttons-color">add_reaction</span>
			</button>
		</div>
	</div>
</div>
