<?php
declare(strict_types=1);

use Models\Emotion;
use function Lib\Utils\display_icon;
use function Lib\Utils\select_toolbar_item;

$css[] = 'navbar.css';
$css[] = 'chat-container.css';
$css[] = 'post.css';

global $connected_user;
global $second_segment;
$username = htmlspecialchars($connected_user->username);
?>
<div class="toolbar-container">
	<div class="toolbar-top-container">
		<a class="logo-link" href="/">
			<img src="<?= display_icon($connected_user) ?>" alt="logo">
		</a>
		<a class="toolbar-item" href="/">
			<span class="material-symbols-outlined <?= select_toolbar_item('/') ?>">home</span>
			<span class="<?= select_toolbar_item('/') ?>">Accueil</span>
		</a>
		<?php
		if (isset($connected_user)) { ?>
		<a class="toolbar-item" href="/profile/<?= $connected_user->username ?>">
			<span class="material-symbols-outlined <?= select_toolbar_item("/profile/$second_segment") ?>">person</span>
			<span class="<?= select_toolbar_item("/profile/$second_segment") ?>">Profil</span>
		</a>

		<a class="toolbar-item" href="/friends">
			<span class="material-symbols-outlined <?= select_toolbar_item('/friends') ?>">group</span>
			<span class="<?= select_toolbar_item('/friends') ?>">Amis</span>
		</a>

		<a class="toolbar-item" href="/options">
			<span class="material-symbols-outlined <?= select_toolbar_item('/options') ?>">pending</span>
			<span class="<?= select_toolbar_item('/options') ?>">Options</span>
		</a>

		<button class="toolbar-chat-btn">Chat</button>

		<dialog class='chat-dialog'>
			<div class='chat-container chat-container-dialog'>
				<div class="chat-header">
					<button class="close-chat-dialog-btn action-btn">
						<span class="material-symbols-outlined action-btn-color ">close</span>
					</button>
				</div>
				<div class="chat-content">
					<div class='chat-avatar'>
						<a href="/profile/<?= $username ?>">
							<img src="<?= $connected_user->displayAvatar() ?>" alt='avatar'>
						</a>
					</div>
					<div class='chat-right'>
						<form class='post-form' action='/chat' method='post' enctype='multipart/form-data'>
							<textarea class='chat-area' maxlength='400' placeholder='Chatter quelque chose...' name='content'></textarea>
							<div class='chat-form-image-container'></div>
							<div class='chat-form-bottom'>
								<input type='file' class='chat-image-input' name='image-content' hidden>
								<button class='chat-image-btn' type='button'>
									<span class='material-symbols-outlined chat-action-buttons-color'>image</span>
								</button>
								<div class='emotions'>
									<?php
									for ($i = 1; $i < count(Emotion::cases()) + 1; $i++) {
										?>
										<label>
											<input
												class="emotion"
												hidden
												name="emotion"
												required
												type="radio"
												value="<?= $i ?>"
												<?= $i === 1 ? 'checked' : '' ?>
											/>
											<span class="emoji-span twemoji-load"><?= Emotion::cases()[$i - 1]->display() ?></span>
										</label>
										<?php
									}
									?>
								</div>
								<button class="chat-btn" type="submit" disabled>Chat</button>
								<div class="chat-count">
									<span class="chat-count-number">0</span>
									<span class="chat-count-max">/ 400</span>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</dialog>
	</div>
	<div class="user-info">
		<a href="/profile/<?= $username ?>">
			<img alt="avatar" class="user-avatar" src="<?= $connected_user->displayAvatar() ?>">
		</a>
		<div class="user-names-container">
			<a href="/profile/<?= $username ?>" class="user-display-name">
				<span><?= $connected_user->getDisplayOrUsername() ?></span>
			</a>
			<a href="/profile/<?= $username ?>" class="user-username">
				<span><?= "@$username" ?></span>
			</a>
		</div>
		<a class="user-logout" href="/logout">
			<span class="logout-btn material-symbols-outlined">logout</span>
		</a>
	</div>
	<?php
	} ?>
</div>
