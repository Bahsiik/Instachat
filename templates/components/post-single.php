<?php
declare(strict_types=1);

use Controllers\Posts\GetComments;
use Controllers\Users\GetUser;
use Models\Emotion;

$user_controller = new GetUser();

global $post;
global $connected_user;
$comments = (new GetComments())->execute($post->id);
$user = $user_controller->execute($post->author_id);
?>
<div class="post-container" data-post-id="<?= $post->id ?>">
	<div class="post-avatar">
		<img src="<?= $user->displayAvatar() ?>" alt="avatar">
	</div>
	<div class="post-right-part">
		<div class="post-info">
			<div class="post-user-info">
				<p class="post-display-name">
					<?= $user->getDisplayOrUsername() ?>
				</p>
				<p class="post-username">
					<?= "@$user->username" ?>
				</p>
			</div>
			<div class="post-emotion">
				<span class="post-emotion twemoji-load"><?= Emotion::cases()[$post->emotion->value - 1]->display() ?></span>
			</div>
			<?php
			if ($connected_user->id === $post->author_id) {
				?>
				<div class='post-menu'>
					<button type='submit' class='post-menu-btn action-btn'>
						<span class='material-symbols-outlined action-btn-color'>more_horiz</span>
					</button>
				</div>
				<div class='menu-container menu-hidden'>
					<input type='hidden' name='post_id' value="<?= $post->id ?>">
					<button class='menu-delete-btn'>
						Supprimer
						<span class='material-symbols-outlined menu-delete-symbol'>close</span>
					</button>
				</div>
				<?php
			}
			?>
		</div>
		<div class="post-content">
			<?php
			if (isset($post->content)) echo htmlspecialchars($post->content); ?>
		</div>
		<div class="post-bottom-info subtitle">
			<div class="post-date">
				<?php
				format_date_time($post->creation_date);
				?>
			</div>
			<p class="post-replies">
				<span class="bold"><?= count($comments) ?></span>
				Réponses
			</p>
			<p class="post-reactions">
				<span class="bold"><?= 0 ?></span>
				Réactions
			</p>
		</div>
		<div class="post-action-buttons">
			<button class="post-comment-btn action-btn">
				<span class="material-symbols-outlined action-btn-color">chat_bubble</span>
				<span class="post-comment-count">
					<?php
					if (count($comments) > 0) echo count($comments);
					?>
				</span>
			</button>
			<button class="post-share-btn action-btn">
				<span class="material-symbols-outlined action-btn-color">ios_share</span>
			</button>
			<button class="post-reaction-btn action-btn">
				<span class="material-symbols-outlined action-btn-color">add_reaction</span>
			</button>
		</div>
	</div>
</div>
