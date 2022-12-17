<?php
declare(strict_types=1);

$css = ['profile.css', 'reaction.css', 'toolbar.css'];
$js = ['fetch-feed.js', 'profile.js', 'posts.js'];

ob_start();
require_once 'components/toolbar.php';

global $connected_user, $user, $friend_list, $friend_requests, $sent_requests, $friendship, $user_posts, $is_connected_user_blocked, $is_user_blocked, $reactions_list, $trends;
$username = htmlspecialchars($user->username);

$title = "Instachat | $username";

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
						<p class="display-name"><?= $user->getDisplayOrUsername() ?></p>
						<p class="username">@<?= $username ?></p>
					</div>
					<?php
					if ($is_user_blocked) {
					?>
				</div>
				<h2>Vous avez bloqué @<?= $username ?>.</h2>
				<?php
				} else if ($is_connected_user_blocked) {
				?>
			</div>
			<h2>@<?= $username ?> vous a bloqué.</h2>
			<?php
			} else {
			?>
			<div class="profile-info-inscription-date">
				<p class="inscription-date">Membre depuis le</p>
				<p class="inscription-date"><?php
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
					<p class="friends-text">ami<?= count($friend_list) > 1 ? 's' : '' ?> </p>
				</div>
				<div class="profile-info-data-content">
					<p class="posts-number"> <?= count($user_posts) ?> </p>
					<p class="posts-text">chat<?= count($user_posts) > 1 ? 's' : '' ?></p>
				</div>
				<div class="profile-info-data-content">
					<p class="reactions-number"><?= count($reactions_list) ?></p>
					<p class="reactions-text">réaction<?= count($reactions_list) > 1 ? 's' : '' ?></p>
				</div>
			</div>
		</div>
		</div>
		<div class="profile-actions">
			<?php
			if ($connected_user->id === $user->id) {
				?>
				<form action="" method="post">
					<button class="material-symbols-outlined cancel" type="submit">edit</button>
				</form>
				<?php
			} else if ($friendship === 1) {
				?>
				<form action="/remove-friend" method="post">
					<input type="hidden" name="friend_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= $username ?>">
					<button class="material-symbols-outlined cancel" type="submit" title="Supprimer cet ami">
						person_remove
					</button>
				</form>
				<form action="/block-user" method="post">
					<input type="hidden" name="blocked_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= $username ?>">
					<button class="material-symbols-outlined block" type="submit" title="Bloquer cet utilisateur">
						block
					</button>
				</form>
				<?php
			} else if ($friendship === 2) {
				?>
				<form action="/accept-friend" method="post">
					<input type="hidden" name="requester_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= $username ?>">
					<button class="material-symbols-outlined cancel" type="submit" title="Accepter la demande d'ami">
						how_to_reg
					</button>
				</form>
				<form action="/decline-friend" method="post">
					<input type="hidden" name="requester_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= $username ?>">
					<button class="material-symbols-outlined cancel" type="submit" title="Refuser la demande d'ami">
						close
					</button>
				</form>
				<form action="/block-user" method="post">
					<input type="hidden" name="blocked_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= $username ?>">
					<button class="material-symbols-outlined block" type="submit" title="Bloquer cet utilisateur">
						block
					</button>
				</form>
				<?php
			} else if ($friendship === 3) {
				?>
				<form action="/cancel-friend" method="post">
					<input type="hidden" name="requested_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= $username ?>">
					<button class="material-symbols-outlined cancel" title="Annuler votre demande d'ami" type="submit">
						close
					</button>
				</form>
				<form action="/block-user" method="post">
					<input type="hidden" name="blocked_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= $username ?>">
					<button class="material-symbols-outlined block" type="submit" title="Bloquer cet utilisateur">
						block
					</button>
				</form>
				<?php
			} else {
				?>
				<form action="/send-friend-request" method="post">
					<input type="hidden" name="requested_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= $username ?>">
					<button class="material-symbols-outlined cancel" title="Envoyer une demande d'ami" type="submit">
						person_add
					</button>
				</form>
				<form action="/block-user" method="post">
					<input type="hidden" name="blocked_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= $username ?>">
					<button class="material-symbols-outlined block" type="submit" title="Bloquer cet utilisateur">
						block
					</button>
				</form>
				<?php
			}
			?>
		</div>
		<?php
		}
		?>
		</div>
		</div>
		<div class="profile-bottom-container">
			<?php
			if ($is_user_blocked) { ?>
				<h2>Vous avez bloqué @<?= $username ?>. Par conséquent, vous ne voyez aucun contenu relatif à ce compte. Pour revoir le contenu de cet
					utilisateur, débloquez le depuis les options.</h2>
				<?php
			} else if ($is_connected_user_blocked) {
				?>
				<h2><?= $username ?> vous a bloqué. Par conséquent, vous ne pouvez accéder à aucun contenu de ce compte.</h2>
				<?php
			} else {
				?>
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
									require 'components/post-feed.php';
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
			}
			?>
		</div>
	</main>
<?php
$content = ob_get_clean();
require_once 'layout.php';
