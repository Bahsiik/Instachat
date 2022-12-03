<?php $css[] = 'toolbar.css'; ?>
<?php global $connected_user; ?>
<div class="toolbar-container">
    <a class="logo-link" href="/">
        <img src="../static/images/logo.png" alt="logo">
    </a>
    <a class="toolbar-item" href="/">
        <span class="material-symbols-outlined">home</span>
        Accueil
    </a>
    <?php if (isset($connected_user)) { ?>
    <a class="toolbar-item" href="">
        <span class="material-symbols-outlined">person</span>
        Profil
    </a>
    <a class="toolbar-item" href="">
        <span class="material-symbols-outlined">group</span>
        Amis
    </a>
    <a class="toolbar-item" href="/options">
        <span class="material-symbols-outlined">pending</span>
        Options
    </a>
        <button class="chat-btn">Chat</button>
        <a class="toolbar-item" href="/logout">
            <span class="material-symbols-outlined">logout</span>
            Déconnexion
        </a>
    <?php } ?>
</div>