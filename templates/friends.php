<?php
declare(strict_types=1);

use Controllers\Users\GetUser;

$friend_controller = new GetUser();

$css[] = 'friends.css';
$js[] = 'tabbed-menu.js';
$js[] = 'friends.js';

ob_start();
require_once('toolbar.php');

global $connected_user;
global $friend_list;
global $friend_requests;
global $sent_requests;
?>
	<div class="friends-tab-container">
		<div class="tabbed-menu">
			<div class="selected tab friends"><p>Amis</p></div>
			<div class="tab waitings"><p>Demandes</p></div>
			<div class="tab requests"><p>Requêtes</p></div>
		</div>
		<div class="content">

			<div class="friends-list">
				<?php
				foreach ($friend_list as $name => $value) {
					$friend_id = ($connected_user->id === $value->requester_id) ? $value->requested_id : $value->requester_id;
					$friend = $friend_controller->execute($friend_id);
					?>
					<div class="friend">
						<div class="friend-info">
							<div class="friend-avatar">
								<img src="<?= $friend->displayAvatar() ?>" alt="Avatar">
							</div>
							<div class="friend-info-text">
								<div class="friend-name">
									<p><?= htmlspecialchars($friend->username) ?></p>
								</div>
								<div class="friendship-term">
									<p>Amis depuis <?php
										format_date_time($value->responseDate) ?></p>
								</div>
							</div>
						</div>
						<div class="friend-actions">
							<form action="/remove-friend" method="post">
								<input type="hidden" name="friend_id" value="<?= $friend->id ?>">
								<button class="material-symbols-outlined cancel" type="submit">close</button>
							</form>
						</div>
					</div>
					<?php
				}
				?>
			</div>

			<div class="waiting-list hidden">
				<?php
				foreach ($friend_requests as $name => $value) {
					$friend_id = ($connected_user->id === $value->requester_id) ? $value->requested_id : $value->requester_id;
					$friend = $friend_controller->execute($friend_id);
					?>
					<div class="friend">
						<div class="friend-info">
							<div class="friend-avatar">
								<img src="<?= $friend->displayAvatar() ?>" alt="Avatar">
							</div>
							<div class="friend-info-text">
								<div class="friend-name">
									<p><?= htmlspecialchars($friend->username) ?></p>
								</div>
								<div class="friendship-term">
									<p>Demande reçu</p>
								</div>
							</div>
						</div>
						<div class="friend-actions">
							<form action="/accept-friend" method="post">
								<input type="hidden" name="requester_id" value="<?= $friend->id ?>">
								<button class="material-symbols-outlined cancel" type="submit">how_to_reg</button>
							</form>
							<form action="/decline-friend" method="post">
								<input type="hidden" name="requester_id" value="<?= $friend->id ?>">
								<button class="material-symbols-outlined cancel" type="submit">close</button>
							</form>
						</div>
					</div>
					<?php
				}
				?>
			</div>

			<div class="requests-list hidden">
				<?php
				foreach ($sent_requests as $name => $value) {
					$friend_id = ($connected_user->id === $value->requester_id) ? $value->requested_id : $value->requester_id;
					$friend = $friend_controller->execute($friend_id);
					?>
					<div class="friend">
						<div class="friend-info">
							<div class="friend-avatar">
								<img src="<?= $friend->displayAvatar() ?>" alt="Avatar">
							</div>
							<div class="friend-info-text">
								<div class="friend-name">
									<p><?= htmlspecialchars($friend->username) ?></p>
								</div>
								<div class="friendship-term">
									<p>Requête envoyée</p>
								</div>
							</div>
						</div>
						<div class="friend-actions">
							<form action="/cancel-friend" method="post">
								<input type="hidden" name="requested_id" value="<?= $friend->id ?>">
								<button class="material-symbols-outlined cancel" type="submit">close</button>
							</form>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>

<?php
require_once('trends.php');
$content = ob_get_clean();
require_once('layout.php');
