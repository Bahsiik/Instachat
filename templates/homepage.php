<?php
declare(strict_types=1);

use Models\Emotion;

$title = 'Page d\'accueil';
$css = ['homepage.css', 'reaction.css'];
$js = ['posts.js'];

ob_start();
require_once 'components/navbar.php';

global $connected_user;
global $posts; ?>
	<main class="homepage-container">
		<div class="title">
			<h1>Accueil</h1>
		</div>
		<div class="chat-container">
			<div class="chat-avatar">
				<a href="/profile/<?= $connected_user->username ?>">
					<img src="<?= $connected_user->displayAvatar() ?>" alt="avatar">
				</a>
			</div>
			<div class="chat-right">
				<form class="post-form" action="/chat" method="post" enctype="multipart/form-data">
					<textarea class="chat-area" maxlength="400" name="content" placeholder="Chatter quelque chose..."></textarea>
					<div class="chat-form-image-container"></div>
					<div class="chat-form-bottom">
						<input type='file' class='chat-image-input' name="image-content" hidden>
						<button class="chat-image-btn" type="button">
							<span class="material-symbols-outlined chat-action-buttons-color">image</span>
						</button>
						<div class="emotions">
							<?php
							for ($i = 1; $i < count(Emotion::cases()) + 1; $i++) {
								?>
								<label>
									<input type="radio" name="emotion" class="emotion" value="<?= $i ?>" <?= $i === 1 ? 'checked' : '' ?> required hidden/>
									<span class="emoji-span twemoji-load"><?= Emotion::cases()[$i - 1]->display() ?></span>
								</label>
								<?php
							}
							?>
						</div>
						<button class="chat-btn" type="submit" disabled>Chat</button>
						<div class="chat-count">
							<span class="chat-count-number">0</span>
							<span class="chat-count-max">/ 400</span>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="feed-container">
			<?php
			if (count($posts) > 0) {
				global $post;
				foreach ($posts as $post) require 'components/post-feed.php';
			} else {
				?>
				<div class="no-post">
					<p>Il n'y a pas de post pour le moment</p>
				</div>
				<?php
			}
			?>
		</div>
	</main>
<?php
require_once 'components/trends.php';
$content = ob_get_clean();
require_once 'layout.php';
