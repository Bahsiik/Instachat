<?php
declare(strict_types=1);

$css = ['profile.css', 'comment.css', 'reaction.css', 'navbar.css'];
$js = ['fetch-feed.js', 'profile.js', 'posts.js', 'comments.js', 'tabbed-menu.js'];

global $connected_user, $user, $friend_list, $friend_requests, $sent_requests, $friendship, $user_posts, $user_comments, $user_reactions, $posts_reacted, $is_connected_user_blocked, $is_user_blocked, $blocked_users, $blocked_words, $trends;

$title = htmlspecialchars($user->username);
ob_start();
require_once 'components/navbar.php';
?>
	<main class="profile-container">
		<div class="title">
			<h1>Profil de <?= htmlspecialchars($user->username) ?></h1>
		</div>
		<div class="profile-info-container">
			<div class="profile-info">
				<div class="profile-info-avatar">
					<img src="../static/images/logo-<?= $user->color->lowercaseName() ?>.png" alt="avatar">
				</div>
				<div class="profile-info-middle">
					<div class="profile-info-username">
						<p class="display-name"><?= $user->getDisplayOrUsername() ?></p>
						<p class="username">@<?= htmlspecialchars($user->username) ?></p>
					</div>
					<?php
					if ($is_user_blocked) {
					?>
				</div>
				<h2>Vous avez bloqué @<?= htmlspecialchars($user->username) ?>.</h2>
				<?php
				} else if ($is_connected_user_blocked) {
				?>
			</div>
			<h2>@<?= htmlspecialchars($user->username) ?> vous a bloqué.</h2>
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
				if ($user->bio === null || $user->bio === '') {
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
					<p class="reactions-number"><?= count($user_reactions) ?></p>
					<p class="reactions-text">réaction<?= count($user_reactions) > 1 ? 's' : '' ?></p>
				</div>
			</div>
		</div>
		</div>
		<div class="profile-actions">
			<?php
			if ($connected_user->id === $user->id) {
				?>
				<form action="" method="post">

				</form>
				<?php
			} else if ($friendship === 1) {
				?>
				<form action="/remove-friend" method="post">
					<input type="hidden" name="friend_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= htmlspecialchars($user->username) ?>">
					<button class="material-symbols-outlined cancel" type="submit" title="Supprimer cet ami">
						person_remove
					</button>
				</form>
				<form action="/block-user" method="post">
					<input type="hidden" name="blocked_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= htmlspecialchars($user->username) ?>">
					<button class="material-symbols-outlined block" type="submit" title="Bloquer cet utilisateur">
						block
					</button>
				</form>
				<?php
			} else if ($friendship === 2) {
				?>
				<form action="/accept-friend" method="post">
					<input type="hidden" name="requester_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= htmlspecialchars($user->username) ?>">
					<button class="material-symbols-outlined cancel" type="submit" title="Accepter la demande d'ami">
						how_to_reg
					</button>
				</form>
				<form action="/decline-friend" method="post">
					<input type="hidden" name="requester_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= htmlspecialchars($user->username) ?>">
					<button class="material-symbols-outlined cancel" type="submit" title="Refuser la demande d'ami">
						close
					</button>
				</form>
				<form action="/block-user" method="post">
					<input type="hidden" name="blocked_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= htmlspecialchars($user->username) ?>">
					<button class="material-symbols-outlined block" type="submit" title="Bloquer cet utilisateur">
						block
					</button>
				</form>
				<?php
			} else if ($friendship === 3) {
				?>
				<form action="/cancel-friend" method="post">
					<input type="hidden" name="requested_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= htmlspecialchars($user->username) ?>">
					<button class="material-symbols-outlined cancel" title="Annuler votre demande d'ami" type="submit">
						close
					</button>
				</form>
				<form action="/block-user" method="post">
					<input type="hidden" name="blocked_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= htmlspecialchars($user->username) ?>">
					<button class="material-symbols-outlined block" type="submit" title="Bloquer cet utilisateur">
						block
					</button>
				</form>
				<?php
			} else {
				?>
				<form action="/send-friend-request" method="post">
					<input type="hidden" name="requested_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= htmlspecialchars($user->username) ?>">
					<button class="material-symbols-outlined cancel" title="Envoyer une demande d'ami" type="submit">
						person_add
					</button>
				</form>
				<form action="/block-user" method="post">
					<input type="hidden" name="blocked_id" value="<?= $user->id ?>">
					<input type="hidden" name="redirect" value="/profile/<?= htmlspecialchars($user->username) ?>">
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
				<h2>Vous avez bloqué @<?= htmlspecialchars($user->username) ?>. Par conséquent, vous ne voyez aucun contenu relatif à ce compte. Pour revoir le
					contenu de cet utilisateur, débloquez le depuis les options.</h2>
				<?php
			} else if ($is_connected_user_blocked) {
				?>
				<h2><?= htmlspecialchars($user->username) ?> vous a bloqué. Par conséquent, vous ne pouvez accéder à aucun contenu de ce compte.</h2>
				<?php
			} else {
				?>
				<div class="profile-list-container tabbed-menu">
					<div class="tabs">
						<div class="tab selected "><p>Chats</p></div>
						<div class="tab"><p>Commentaires</p></div>
						<div class="tab"><p>Réactions</p></div>
					</div>
					<div class="content">
						<div class="user-post-container selected">
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
						<div class="user-comment-container">
							<?php
							if (count($user_comments) > 0) {
								global $comment;
								foreach ($user_comments as $comment) {
									require 'components/comment.php';
								}
							} else {
								?>
								<div class="no-post">
									<h2>Aucun commentaire trouvé</h2>
								</div>
								<?php
							}
							?>
						</div>
						<div class="user-reaction-container">
							<?php
							if (count($posts_reacted) > 0) {
								global $post;
								foreach ($posts_reacted as $post) {
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
