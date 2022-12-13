<?php
declare(strict_types=1);

global $reactions;
global $connected_user;
?>
<div class="reactions">
	<?php
	foreach ($reactions as $reaction) {
		?>
		<span class='reaction <?= $reaction->hasReacted($connected_user->id) ? 'reacted' : '' ?>' data-id='<?= $reaction->id ?>'
		      data-post-id='<?= $reaction->postId ?>'>
			<?= $reaction->emoji . $reaction->getCount() ?>
		</span>
		<?php
	}
	?>
</div>
