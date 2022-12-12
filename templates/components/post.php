<?php
declare(strict_types=1);

use Controllers\Users\GetUser;
use Models\Emotion;
use Src\Controllers\comments\GetComments;


$user_controller = new GetUser();


global $post;
global $connected_user;
$comments = (new GetComments())->execute($post->id);
$user = $user_controller->execute($post->authorId);
?>
<article class="post-container" data-post-id="<?= $post->id ?>">
	<div class="post-avatar">
		<a href="/profile/<?= $user->username ?>">
			<img src="<?= $user->displayAvatar() ?>" alt='avatar'>
		</a>
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
			<div class="post-dot-separator">·</div>
			<div class="post-date">
				<?php
				format_date_time_diff($post->creationDate);
				?>
			</div>
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
					<button type='button' class='menu-delete-btn'>
						Supprimer
						<span class='material-symbols-outlined menu-delete-symbol'>close</span>
					</button>
					<dialog class="delete-dialog">
						<form action='/delete?type=post' method='post'>
							<input type='hidden' name='post_id' value="<?= $post->id ?>">
							<p>Êtes-vous sûr de vouloir supprimer ce post ?</p>
							<button type="button" value="cancel" class="modal-cancel-btn">Annuler</button>
							<button type="submit" value="delete" class="modal-delete-btn">Supprimer</button>
						</form>
					</dialog>
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
		<div class="post-action-buttons">
			<button class="post-comment-btn action-btn">
				<span class="material-symbols-outlined action-btn-color">chat_bubble</span>
				<span class="post-comment-count">
				<?php
				if (count($comments) > 0) echo count($comments);
				?>
				</span>
			</button>
			<button class="post-share-btn action-btn" value="<?=$post->id?>">
				<span class="material-symbols-outlined action-btn-color">ios_share</span>
			</button>
			<button class="post-reaction-btn action-btn" >
				<span class="material-symbols-outlined action-btn-color">add_reaction</span>
			</button>
		</div>
	</div>
</article>
