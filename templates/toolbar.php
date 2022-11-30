<?php $title = 'toolbar';
$css = ['toolbar.css'];
?>
	<div class="toolbar_container">
		<img src="../static/images/logo.png" alt="logo">
		<a class="toolbar_item" href="">
			<span class="material-symbols-outlined">home</span>
			Accueil
		</a>
		<a class="toolbar_item" href="">
			<span class="material-symbols-outlined">person</span>
			Profil
		</a>
		<a class="toolbar_item" href="">
			<span class="material-symbols-outlined">group</span>
            Amis
        </a>
        <a class="toolbar_item" href="">
            <span class="material-symbols-outlined">pending</span>
            Options
        </a>
        <div class="toolbar_button">
            <a href="">Chat</a>
        </div>
    </div>

<?php require 'index.php'; ?>