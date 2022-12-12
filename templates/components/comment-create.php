<?php
declare(strict_types=1);

use function Lib\Utils\display_icon;

global $post;
global $connected_user;
?>

<form action="/comment" class='create-comment' method="post">
	<input type="hidden" name="post-id" value="<?= $post->id ?>">
	<a class='user-avatar' href="/profile/<?= $connected_user->username ?>">
		<img src="<?= display_icon($connected_user) ?>" alt='avatar'>
	</a>
	<textarea class="chat-area" maxlength="120" minlength="2" name="content" placeholder="Commenter quelque chose..." required rows="3"></textarea>
	<button class="chat-btn" type="submit">Commenter</button>
</form>
