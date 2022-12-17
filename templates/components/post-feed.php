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
$comments = (new CountComments())->execute($post->id);
$user = $user_controller->execute($post->authorId);
$reactions = (new GetReactionsByPost())->execute($post->id);
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
			global $author_id, $id, $type;
			$author_id = $post->authorId;
			$id = $post->id;
			$type = 'post';
			require 'templates/components/context-menu.php';
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
				if ($comments > 0) echo $comments;
				?>
				</span>
			</button>
			<button class="post-share-btn action-btn" value="<?= $post->id ?>">
				<span class="material-symbols-outlined action-btn-color">link</span>
			</button>
			<button class="post-reaction-btn action-btn" value="<?= $post->id ?>">
				<span class="material-symbols-outlined action-btn-color">add_reaction</span>
			</button>

		</div>
		<?php
		require 'reactions.php' ?>
	</div>
</article>
