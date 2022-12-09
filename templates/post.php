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
				format_date_time($post->creation_date);
				?>
			</div>
			<div class="post-emotion">
				<span
					class="post-emotion twemoji-load"><?= Emotion::cases()[$post->emotion->value - 1]->display() ?></span>
			</div>
			<?php
			if ($connected_user->id === (int)$post->author_id) {
				?>
				<div class="post-menu">
					<button type='submit' class='post-menu-btn'>
						<span class='material-symbols-outlined post-action-buttons-color'>more_horiz</span>
					</button>
				</div>
				<div class="menu-container menu-hidden">
					<form action="/delete-post" method="post">
						<input type="hidden" name="post_id" value="<?= $post->id ?>">
						<button type="submit" class="menu-delete-btn"><span
								class="material-symbols-outlined post-action-buttons-color">close</span>
							Supprimer
						</button>
					</form>
				</div>
				<?php
			}
			?>
		</div>
		<div class="post-content">
			<?php
			if (isset($post->content)) echo htmlspecialchars($post->content); ?>
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
