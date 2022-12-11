<?php
declare(strict_types=1);

$css = ['profile.css', 'post.css'];
$js[] = 'posts.js';


ob_start();
require_once 'components/toolbar.php';
require_once 'src/controllers/reactions/GetReactionsByAuthorId.php';

use Controllers\Reaction\GetReactionsByAuthorId;

global $connected_user, $user, $friend_list, $friend_requests, $sent_requests, $user_posts;
$reactions_list = (new GetReactionsByAuthorId())->execute($user->id);


$friendship = null;

if ($connected_user->id !== $user->id) {
	foreach ($friend_list as $friend) {
		if ($user->id === $friend->requester_id && $connected_user->id === $friend->requested_id || $user->id === $friend->requested_id && $connected_user->id === $friend->requester_id) {
			$friendship = 1;
			break;
		}
	}
	foreach ($friend_requests as $friend) {
		if ($user->id === $friend->requester_id) {
			$friendship = 2;
			break;
		}
	}
	foreach ($sent_requests as $friend) {
		if ($user->id === $friend->requested_id) {
			$friendship = 3;
			break;
		}
	}
}


$title = 'Instachat | ' . $username = htmlspecialchars($user->username);

?>
	<main class="profile-container">
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
						<p class="display-name"><?= $user->display_name !== null ? htmlspecialchars($user->display_name) : $username ?></p>
						<p class="username"><?= '@' . $username ?></p>
					</div>
					<div class="profile-info-inscription-date">
						<p class="inscription-date">Membre depuis le</p>
						<p class="inscription-date"><?=
							format_date_time($user->createdAt) ?></p>
					</div>
				</div>
				<div class="profile-info-right">
					<div class="profile-bio">
						<?php
						if ($user->bio === null) {
							echo $user->id === $connected_user->id ?
								'Ajoutez une bio pour que les autres utilisateurs puissent en savoir plus sur vous !' :
								"Cet utilisateur n'a pas encore ajouté de bio.";
						} else {
							echo htmlspecialchars($user->bio);
						} ?>
					</div>
					<div class="profile-info-data">
						<div class="profile-info-data-content">
							<p class="friends-number"><?= count($friend_list) ?> </p>
							<p class="friends-text"> <?= count($friend_list) <= 1 ? 'ami' : 'amis' ?> </p>
						</div>
						<div class="profile-info-data-content">
							<p class="posts-number"> <?= count($user_posts) ?> </p>
							<p class="posts-text"><?= count($user_posts) <= 1 ? 'chat' : 'chats' ?></p>
						</div>
						<div class="profile-info-data-content">
							<p class="reactions-number"><?= count($reactions_list) ?></p>
							<p class="reactions-text"><?= count($reactions_list) <= 1 ? 'réaction' : 'réactions' ?></p>
						</div>
					</div>
				</div>
			</div>
			<?php
			if ($connected_user->id === $user->id) {
				?>
				<div class="profile-actions">
					<form action="" method="post">
						<button class="material-symbols-outlined cancel" type="submit">edit</button>
					</form>
				</div>
				<?php
			} else if ($friendship === 1) {
				?>
				<div class="profile-actions">
					<form action="/remove-friend" method="post">
						<input type="hidden" name="friend_id" value="<?= $user->id ?>">
						<input type="hidden" name="redirect" value="/profile/<?= $user->username ?>">
						<button class="material-symbols-outlined cancel" type="submit" title="Supprimer cet ami">
							person_remove
						</button>
					</form>
				</div>
				<?php
			} else if ($friendship === 2) {
				?>
				<div class="profile-actions">
					<form action="/accept-friend" method="post">
						<input type="hidden" name="requester_id" value="<?= $user->id ?>">
						<input type="hidden" name="redirect" value="/profile/<?= $user->username ?>">
						<button class="material-symbols-outlined cancel" type="submit"
						        title="Accepter la demande d'ami">how_to_reg
						</button>
					</form>
					<form action="/decline-friend" method="post">
						<input type="hidden" name="requester_id" value="<?= $user->id ?>">
						<input type="hidden" name="redirect" value="/profile/<?= $user->username ?>">
						<button class="material-symbols-outlined cancel" type="submit" title="Refuser la demande d'ami">
							close
						</button>
					</form>
				</div>
				<?php
			} else if ($friendship === 3) {
				?>
				<div class="profile-actions">
					<form action="/cancel-friend" method="post">
						<input type="hidden" name="requested_id" value="<?= $user->id ?>">
						<input type="hidden" name="redirect" value="/profile/<?= $user->username ?>">
						<button class="material-symbols-outlined cancel" type="submit"
						        title="Annuler votre demande d'ami">close
						</button>
					</form>
				</div>
				<?php
			} else {
				?>
				<div class="profile-actions">
					<form action="/send-friend-request" method="post">
						<input type="hidden" name="requested_id" value="<?= $user->id ?>">
						<input type="hidden" name="redirect" value="/profile/<?= $user->username ?>">
						<button class="material-symbols-outlined cancel" type="submit"
						        title="Envoyer une demande d'ami">person_add
						</button>
					</form>
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
								require 'components/post.php';
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
	</main>

<?php
$content = ob_get_clean();
require_once 'layout.php';
