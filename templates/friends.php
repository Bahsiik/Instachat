<?php
declare(strict_types=1);

use Controllers\Users\GetUser;

$friend_controller = new GetUser();

$title = 'Instachat | Amis';
$css = ['friends.css', 'navbar.css'];
$js = ['tabbed-menu.js', 'friends.js'];

ob_start();
require_once 'components/navbar.php';

global $connected_user, $friend_list, $friend_requests, $sent_requests;
?>
	<main class="friends-tab-container tabbed-menu">
		<div class="tabs">
			<div class="tab friends selected"><p>Amis</p></div>
			<div class="tab waitings"><p>Demandes</p></div>
			<div class="tab requests"><p>Requêtes</p></div>
		</div>
		<div class="content">
			<div class="friends-list selected">
				<?php
				if (count($friend_list) > 0) {
					foreach ($friend_list as $name => $value) {
						$friend_id = $connected_user->id === $value->requesterId ? $value->requestedId : $value->requesterId;
						$friend = $friend_controller->execute($friend_id);
						?>
						<div class="friend">
							<div class="friend-info">
								<div class="friend-avatar">
									<a href="/profile/<?= $friend->username ?>">
										<img src="<?= $friend->displayAvatar() ?>" alt="Avatar">
									</a>
								</div>
								<div class="friend-info-text">
									<div class="friend-name">
										<a href="/profile/<?= $friend->username ?>">
											<p><?= htmlspecialchars($friend->username) ?></p>
										</a>
									</div>
									<div class="friendship-term">
										<p>Amis depuis <?php
											format_date_time_diff($value->responseDate, 'le ') ?></p>
									</div>
								</div>
							</div>
							<div class="friend-actions">
								<form action="/remove-friend" method="post">
									<input type="hidden" name="friend_id" value="<?= $friend->id ?>">
									<input type="hidden" name="redirect" value="/friends">
									<button class="material-symbols-outlined cancel" type="submit">close</button>
								</form>
							</div>
						</div>
						<?php
					}
				} else {
					?>
					<div class="empty">
						<h2>Liste d'amis vide</h2>
					</div>
					<?php
				}
				?>
			</div>

			<div class="waiting-list">
				<?php
				if (count($friend_requests) > 0) {
					foreach ($friend_requests as $name => $value) {
						$friend_id = $connected_user->id === $value->requesterId ? $value->requestedId : $value->requesterId;
						$friend = $friend_controller->execute($friend_id);
						?>
						<div class="friend">
							<div class="friend-info">
								<div class="friend-avatar">
									<a href="/profile/<?= $friend->username ?>">
										<img src="<?= $friend->displayAvatar() ?>" alt="Avatar">
									</a>
								</div>
								<div class="friend-info-text">
									<div class="friend-name">
										<a href="/profile/<?= $friend->username ?>">
											<p><?= htmlspecialchars($friend->username) ?></p>
										</a>
									</div>
									<div class="friendship-term">
										<p>Demande reçu</p>
									</div>
								</div>
							</div>
							<div class="friend-actions">
								<form action="/accept-friend" method="post">
									<input type="hidden" name="requester_id" value="<?= $friend->id ?>">
									<input type="hidden" name="redirect" value="/friends">
									<button class="material-symbols-outlined accept" type="submit">how_to_reg</button>
								</form>
								<form action="/decline-friend" method="post">
									<input type="hidden" name="requester_id" value="<?= $friend->id ?>">
									<input type="hidden" name="redirect" value="/friends">
									<button class="material-symbols-outlined cancel" type="submit">close</button>
								</form>
							</div>
						</div>
						<?php
					}
				} else {
					?>
					<div class="empty">
						<h2>Aucune demande d'amis</h2>
					</div>
					<?php
				}
				?>
			</div>

			<div class="requests-list">
				<?php
				if (count($sent_requests) > 0) {


					foreach ($sent_requests as $name => $value) {
						$friend_id = $connected_user->id === $value->requesterId ? $value->requestedId : $value->requesterId;
						$friend = $friend_controller->execute($friend_id);
						?>
						<div class="friend">
							<div class="friend-info">
								<div class="friend-avatar">
									<a href="/profile/<?= $friend->username ?>">
										<img src="<?= $friend->displayAvatar() ?>" alt="Avatar">
									</a>
								</div>
								<div class="friend-info-text">
									<div class="friend-name">
										<a href="/profile/<?= $friend->username ?>">
											<p><?= htmlspecialchars($friend->username) ?></p>
										</a>
									</div>
									<div class="friendship-term">
										<p>Requête envoyée</p>
									</div>
								</div>
							</div>
							<div class="friend-actions">
								<form action="/cancel-friend" method="post">
									<input type="hidden" name="requested_id" value="<?= $friend->id ?>">
									<input type="hidden" name="redirect" value="/friends">
									<button class="material-symbols-outlined cancel" type="submit">close</button>
								</form>
							</div>
						</div>
						<?php
					}
				} else {
					?>
					<div class="empty">
						<h2>Vous n'avez envoyé aucune requête d'amis</h2>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</main>

<?php
require_once 'components/trends.php';
$content = ob_get_clean();
require_once 'layout.php';
