<?php
declare(strict_types=1);

use Controllers\comments\CountComments;
use Controllers\Users\GetUser;
use Models\Emotion;
use Src\Controllers\Reactions\GetReactionsByPost;

$user_controller = new GetUser();


global $connected_user;
global $post;
global $reactions;
$comments_count = (new CountComments())->execute($post->id);
$user = $user_controller->execute($post->authorId);
$reactions = (new GetReactionsByPost())->execute($post->id);
?>
<article class="post-container" data-post-id="<?= $post->id ?>">
	<div class="post-avatar">
		<img src="<?= $user->displayAvatar() ?>" alt="avatar">
	</div>
	<div class="post-main">
		<div class="post-info">
			<a class="post-user-info" href="/profile/<?= $user->username ?>">
				<p class="post-display-name">
					<?= $user->getDisplayOrUsername() ?>
				</p>
				<p class="post-username">
					<?= "@$user->username" ?>
				</p>
			</a>
			<div class="post-emotion">
				<span class="post-emotion twemoji-load"><?= Emotion::cases()[$post->emotion->value - 1]->display() ?></span>
			</div>
			<?php
			if ($connected_user->id === $post->authorId) {
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
		<?php
		if (isset($post->image->data) && str_starts_with($post->image->data, 'data:image')) {
			?>
			<img alt="post-image" class="post-image" src="<?= $post->image->data ?>">
			<?php
		}
		?>
		<p class='post-date'>
			<?php
			format_date_time($post->creationDate);
			?>
		</p>
		<div class="post-bottom-info subtitle">

			<p class="post-replies">
				<span class="bold"><?= $comments_count ?></span>
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
					if ($comments_count > 0) echo $comments_count;
					?>
				</span>
			</button>
			<button class="post-share-btn action-btn" value="<?=$post->id?>">
				<span class="material-symbols-outlined action-btn-color">link</span>
			</button>
			<button class="post-reaction-btn action-btn">
				<span class="material-symbols-outlined action-btn-color">add_reaction</span>
			</button>
			<?php
			require_once 'reactions.php' ?>
		</div>
	</div>
</article>
