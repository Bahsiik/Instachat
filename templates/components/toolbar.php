<?php
declare(strict_types=1);

$css[] = 'toolbar.css';

$current_url = $_SERVER['REQUEST_URI'];
global $connected_user; ?>
<div class="toolbar-container">
	<div class="toolbar-top-container">
		<a class="logo-link" href="/">
			<img src="../static/images/logo-<?= $connected_user->color->lowercaseName() ?>.png" alt="logo">
		</a>
		<a class="toolbar-item" href="/">
			<span
				class="material-symbols-outlined <?= $current_url === '/' ? 'toolbar-item-selected' : '' ?>">home</span>
			<span class="<?= $current_url === '/' ? 'toolbar-item-selected' : '' ?>">Accueil</span>
		</a>
		<?php
		if (isset($connected_user)) { ?>
		<a class="toolbar-item" href="">
			<span class="material-symbols-outlined <?= $current_url === '/profile' ? 'toolbar-item-selected' : '' ?>">person</span>
			<span class="<?= $current_url === '/profile' ? 'toolbar-item-selected' : '' ?>">Profil</span>
		</a>
		<a class="toolbar-item" href="/friends">
			<span class="material-symbols-outlined <?= $current_url === '/friends' ? 'toolbar-item-selected' : '' ?>">group</span>
			<span class="<?= $current_url === '/friends' ? 'toolbar-item-selected' : '' ?>">Amis</span>

		</a>
		<a class="toolbar-item" href="/options">
			<span class="material-symbols-outlined <?= $current_url === '/options' ? 'toolbar-item-selected' : '' ?>">pending</span>
			<span class="<?= $current_url === '/options' ? 'toolbar-item-selected' : '' ?>">Options</span>

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
