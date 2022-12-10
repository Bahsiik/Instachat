<?php
declare(strict_types=1);

$css = ['profile.css', 'post.css'];
$js[] = 'update-feed.js';


ob_start();
require_once('components/toolbar.php');

global $connected_user, $user, $friend_list, $user_posts;


$title = 'Instachat | ' . $username = htmlspecialchars($user->username);

?>
	<div class="profile-container">
		<div class="title">
			<h1>Profil de <?= $username ?></h1>
		</div>
		<div class="profile-info-container">
			<div class="profile-info">
				<div class="profile-info-avatar">
					<img src="../static/images/logo-<?= $user->color->lowercaseName() ?>.png" alt="avatar">
				</div>
				<div class="profile-info-middle">
					<div class="profile-info-username">
						<p class="display-name"><?= ($user->display_name !== null) ? htmlspecialchars($user->display_name) : $username ?></p>
						<p class="username"><?= '@' . $username ?></p>
					</div>
					<div class="profile-info-inscription-date">
						<p class="inscription-date">Membre depuis le</p>
						<p class="inscription-date"><?= format_date_time($user->created_at) ?></p>
					</div>
				</div>
				<div class="profile-info-right">
					<div class="profile-bio">
						<?php
						if ($user->bio == null) {
							if ($user->id == $connected_user->id) {
								echo 'Ajoutez une bio pour que les autres utilisateurs puissent en savoir plus sur vous !';
							} else {
								echo 'Cet utilisateur n\'a pas encore ajouté de bio.';
							}
						} else {
							echo htmlspecialchars($user->bio);
						} ?>
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
							<p class="reactions-number">ching chong</p>
							<p class="reactions-text">Réactions</p>
						</div>
					</div>
				</div>
			</div>
			<?php
			if ($connected_user->id == $user->id) {
				?>
				<div class="profile-actions">
					<button class="material-symbols-outlined">edit</button>
				</div>
				<?php
			}
			?>
		</div>
		<div class="profile-bottom-container">
			<div class="profile-list-container">
				<div class="tabbed-menu">
					<div class="selected tab chats" onclick="showTab(tab1)"><p>Chats</p></div>
					<div class="tab comments" onclick="showTab(tab2)"><p>Commentaires</p></div>
					<div class="tab reactions" onclick="showTab(tab3)"><p>Réactions</p></div>
				</div>
				<div class="tab-content">
					<div class="user-post-container">
						<?php
						if (count($user_posts) > 0) {
							global $post;
							foreach ($user_posts as $post) {
								require('components/post.php');
							}
						} else {
							?>
							<div class="no-post">
								<h2>Aucun post trouvé</h2>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			<?php
			require_once 'components/trends.php';
			?>
		</div>
	</div>

<?php
$content = ob_get_clean();
require_once('layout.php');
