<?php
declare(strict_types=1);

$css[] = 'profile.css';

ob_start();
require_once('components/toolbar.php');

global $connected_user;
global $friend_list;
global $user_posts;


$title = 'Instachat | ' . $username = htmlspecialchars($connected_user->username);

?>
	<div class="profile-container">
		<div class="title">
			<h1>Profil de <?= $username ?></h1>
		</div>
		<div class="profile-info-container">
			<div class="profile-info">
				<div class="profile-info-avatar">
					<img src="../static/images/logo-<?= $connected_user->color->lowercaseName() ?>.png" alt="avatar">
				</div>
				<div class="profile-info-middle">
					<div class="profile-info-username">
						<p class="display-name"><?= ($connected_user->display_name !== null) ? htmlspecialchars($connected_user->display_name) : $username ?></p>
						<p class="username"><?= '@' . $username ?></p>
					</div>
					<div class="profile-info-inscription-date">
						<p class="inscription-date">Membre depuis le</p>
						<p class="inscription-date"><?= format_date_time($connected_user->created_at) ?></p>
					</div>
				</div>
				<div class="profile-info-right">
					<div class="profile-bio">
						<?= ($connected_user->bio == null) ? 'Vous n\'avez pas encore renseigné de bio vous concernant..' : htmlspecialchars($connected_user->bio) ?>
					</div>
					<div class="profile-info-data">
						<div class="profile-info-data-content">
							<p class="friends-number"><?= count($friend_list) ?> </p>
							<p class="friends-text"> <?= (count($friend_list) <= 1) ? 'ami' : 'amis' ?> </p>
						</div>
						<div class="profile-info-data-content">
							<p class="posts-number"> <?= count($user_posts) ?> </p>
							<p class="posts-text"><?= (count($user_posts) <= 1) ? 'chat' : 'chats' ?></p>
						</div>
						<div class="profile-info-data-content">
							<p class="reactions-number">50</p>
							<p class="reactions-text">Réactions</p>
						</div>
					</div>
				</div>
			</div>
			<div class="profile-actions">
				<button class="material-symbols-outlined">edit</button>
			</div>
		</div>
	</div>

<?php
$content = ob_get_clean();
require_once('layout.php');
