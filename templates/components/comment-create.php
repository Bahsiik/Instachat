<?php
declare(strict_types=1);

use function Lib\Utils\display_icon;

global $post;
global $connected_user;
?>

<div class="comment-chat-container">
	<div class='comment-chat-avatar'>
		<a class='user-avatar' href="/profile/<?= $connected_user->username ?>">
			<img src="<?= display_icon($connected_user) ?>" alt='avatar'>
		</a>
	</div>
	<div class="comment-chat-right">
		<form action='/comment' class='create-comment' method='post'>
			<span class='create-comment-reply'></span>
			<input type="hidden" name="post-id" value="<?= $post->id ?>">
			<textarea
				class="comment-chat-area"
				maxlength="120"
				minlength="2"
				name="content"
				placeholder="Commenter quelque chose..."
				required
				rows="3"
			></textarea>
			<div class="comment-bottom">
				<div class="comment-chat-count">
					<span class='comment-chat-count-number'>0</span>
					<span class='comment-chat-count-max'>/ 120</span>
				</div>
				<button class='comment-chat-btn' type='submit' disabled>Commenter</button>
			</div>
		</form>
	</div>
</div>
