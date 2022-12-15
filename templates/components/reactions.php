<?php
declare(strict_types=1);

global $reactions;
global $connected_user;
?>
<form class="reactions" method="post">
	<?php
	foreach ($reactions as $reaction) {
		$reacted = $reaction->hasReacted($connected_user->id);
		?>
		<button class='reaction <?= $reacted ? 'reacted' : '' ?>' formaction="<?= $reacted ? 'un-react' : 'react' ?>?id=<?= $reaction->id ?>">
			<?= $reaction->emoji . $reaction->getCount() ?>
		</button>
		<?php
	}
	?>
</form>
