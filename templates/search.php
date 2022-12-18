<?php
declare(strict_types=1);

global $connected_user, $users_searched, $posts_searched, $input_searched, $trends;

$title = $input_searched;
$css = ['search.css', 'reaction.css', 'navbar.css'];
$js = ['fetch-feed.js', 'search.js', 'posts.js', 'tabbed-menu.js'];

//echo $_GET['q'];
ob_start();
require_once 'components/navbar.php';
?>
	<main class="search-container">
		<div class="title">
			<h1>Recherche - <?= htmlspecialchars($input_searched) ?></h1>
		</div>
		<div class="searched-container tabbed-menu">
			<div class="tabs">
				<div class="tab selected"><p>Posts</p></div>
				<div class="tab"><p>Utilisateurs</p></div>
			</div>
			<div class="content">
				<div class="found-posts selected">
					<?php
					if (count($posts_searched) > 0) {
						global $post;
						foreach ($posts_searched as $post) {
							require 'components/post-feed.php';
						}
					} else {
						?>
						<div class="empty">
							<h2>Aucun post trouvé</h2>
						</div>
						<?php
					}
					?>
				</div>
				<div class="found-users">
					<?php
					if (count($users_searched) > 0) {
						global $user;
						foreach ($users_searched as $user) {
							?>
							<div class="user">
								<a href="/profile/<?= htmlspecialchars($user->username) ?>">
									<div class="left-part">
										<div class="avatar">
											<img src="<?= $user->displayAvatar() ?>" alt="Avatar de <?= htmlspecialchars($user->username) ?>">
										</div>
										<div class="name">
											<div class="display-name">
												<p><?= $user->display_name != null ? htmlspecialchars($user->display_name) : htmlspecialchars($user->username) ?></p>
											</div>
											<div class="username">
												<p>@<?= htmlspecialchars($user->username) ?></p>
											</div>
										</div>
									</div>
									<div class="right-part">
										<div class="bio">
											<p><?= $user->bio != null ? '"' . htmlspecialchars($user->bio) . '"' : '"Cet utilisateur n\'a pas encore ajouté de bio."' ?></p>
										</div>
									</div>
								</a>
							</div>
							<?php
						}
					} else {
						?>
						<div class="empty">
							<h2>Aucun utilisateur trouvé</h2>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</main>
<?php

require_once 'components/trends.php';
$content = ob_get_clean();
require_once 'layout.php';

//echo 'input:' . json_encode($input_searched) . '<br>' .'recherche-USER: ' . json_encode($users_searched) . '<br>' . 'recherche-POST: ' . json_encode($posts_searched);