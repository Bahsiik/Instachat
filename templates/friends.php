<?php
declare(strict_types=1);

use Controllers\User\GetUser;

require_once('src/controllers/user/GetUser.php');


$friend_controller = new GetUser();


$css[] = 'friends.css';
$js[] = 'tabbed-menu.js';

ob_start();
require_once('toolbar.php');

global $connected_user;
global $friend_list;
?>
	<div class="friends-tab-container">
		<div class="tabbed-menu">
			<div class="selected tab"><p>Amis</p></div>
			<div class="tab"><p>Demandes</p></div>
			<div class="tab"><p>Requêtes</p></div>
		</div>
		<div class="content">
			<div class="friends-list">
				<?php
				foreach ($friend_list as $name => $value) {
					$friend_id = ($connected_user->id == $value->requester_id) ? $value->requested_id : $value->requester_id;
					$friend = $friend_controller->execute($friend_id);
					?>

					<div class="friend">
						<div class="friend-info">
							<div class="friend-avatar">
								<img src="<?= $friend->displayAvatar($friend)?>" alt="Avatar">
							</div>
							<div class="friend-info-text">
								<div class="friend-name">
									<p><?= $friend->username ?></p>
								</div>
								<div class="friendship-term">
									<p>Amis depuis <?php format_date_time($value->responseDate)?></p>
								</div>
							</div>
						</div>
						<div class="friend-actions">
							<button class="material-symbols-outlined">delete</button>
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