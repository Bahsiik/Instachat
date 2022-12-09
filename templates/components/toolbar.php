<?php
declare(strict_types=1);

use function Lib\Utils\selectToolbarItem;

$css[] = 'toolbar.css';

global $connected_user; ?>
<div class="toolbar-container">
	<div class="toolbar-top-container">
		<a class="logo-link" href="/">
			<img src="../static/images/logo-<?= $connected_user->color->lowercaseName() ?>.png" alt="logo">
		</a>
		<a class="toolbar-item" href="/">
			<span
				class="material-symbols-outlined <?= selectToolbarItem('/') ?>">home</span>
			<span class="<?= selectToolbarItem('/') ?>">Accueil</span>
		</a>
		<?php
		if (isset($connected_user)) { ?>
		<a class="toolbar-item" href="/profile">
			<span class="material-symbols-outlined <?= selectToolbarItem('/profile') ?>">person</span>
			<span class="<?= selectToolbarItem('/profile') ?>">Profil</span>
		</a>
		<a class="toolbar-item" href="/friends">
			<span class="material-symbols-outlined <?= selectToolbarItem('/friends') ?>">group</span>
			<span class="<?= selectToolbarItem('/friends') ?>">Amis</span>

		</a>
		<a class="toolbar-item" href="/options">
			<span class="material-symbols-outlined <?= selectToolbarItem('/options') ?>">pending</span>
			<span class="<?= selectToolbarItem('/options') ?>">Options</span>

		</a>
		<button class="chat-btn">Chat</button>
	</div>
	<div class="user-info">
		<img class="user-avatar" src="../static/images/logo-<?= $connected_user->color->lowercaseName() ?>.png"
		     alt="avatar">
		<div class="user-names-container">
                <span class="user-display-name">
                <?= $connected_user->getDisplayOrUsername() ?>
                </span>
			<span class="user-username">
					<?php
					$username = htmlspecialchars($connected_user->username);
					echo "@$username"
					?>
                </span>
		</div>
		<a class="user-logout" href="/logout">
			<span class="logout-btn material-symbols-outlined">logout</span>
		</a>
	</div>
	<?php
	} ?>
</div>
