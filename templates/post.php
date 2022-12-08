<?php

use Controllers\User\GetUser;
use Model\Comment;
use Model\Emotion;
use Model\Post;
use Model\User;

require_once('src/controllers/user/GetUser.php');

$user_controller = new GetUser();
/** @var Post $post */
global $post;
/** @var User $user */
$user = $user_controller->execute($post->author_id);
/** @var Comment[] $comments */
global $comments; ?>
<div class="post-container">
	<div class="post-avatar">
		<img src="<?= $user->displayAvatar() ?>" alt="avatar">
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
				$post_date = $post->creation_date;
				$current_date = new DateTime();
				$diff = $current_date->diff($post_date);
				$date_only_formatter = IntlDateFormatter::create(
					'fr_FR',
					IntlDateFormatter::FULL,
					IntlDateFormatter::FULL,
					'Europe/Paris',
					IntlDateFormatter::GREGORIAN,
					'd MMMM yyyy'
				);
				if ($diff->days > 0) {
					echo $date_only_formatter->format($post_date);
				} else if ($diff->h > 0) {
					echo $diff->h . ' h';
				} else if ($diff->i > 0) {
					echo $diff->i . ' min';
				} else if ($diff->s >= 0) {
					echo $diff->s . 's';
				}
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


