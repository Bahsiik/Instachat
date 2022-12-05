<?php $css[] = 'toolbar.css'; ?>
<?php global $connected_user; ?>
<div class="toolbar-container">
    <div class="toolbar-top-container">
        <a class="logo-link" href="/">
            <img src="../static/images/logo.png" alt="logo">
        </a>
        <a class="toolbar-item" href="/">
            <span class="material-symbols-outlined toolbar-item-selected">home</span>
            <span class="toolbar-item-selected">Accueil</span>
        </a>
        <?php if (isset($connected_user)) { ?>
        <a class="toolbar-item" href="">
            <span class="material-symbols-outlined">person</span>
            Profil
        </a>
        <a class="toolbar-item" href="/friends">
            <span class="material-symbols-outlined">group</span>
            Amis
        </a>
	    <a class="toolbar-item" href="/options">
		    <span class="material-symbols-outlined">pending</span>
		    Options
	    </a>
	    <button class="chat-btn">Chat</button>
    </div>
	<div class="user-info">
		<img class="user-avatar" src="../static/images/logo.png" alt="avatar">
		<div class="user-names-container">
                <span class="user-display-name">
                <?= $connected_user->getDisplayOrUsername() ?>
                </span>
			<span class="user-username">
                    <?= "@$connected_user->username" ?>
                </span>
		</div>
		<a class="user-logout" href="/logout">
			<span class="logout-btn material-symbols-outlined">logout</span>
		</a>
	</div>
	<?php } ?>
</div>