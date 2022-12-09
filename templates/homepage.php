<?php
declare(strict_types=1);

use Models\Emotion;
use function Lib\Utils\display_icon;

$css = ['homepage.css', 'post.css'];
$title = 'Instachat';
$js = ['homepage.js', 'update-feed.js'];

ob_start();
require_once('components/toolbar.php');

global $connected_user;
global $posts; ?>
	<div class="homepage-container">
		<div class="title">
			<h1>Accueil</h1>
		</div>
		<div class="chat-container">
			<div class="chat-avatar">
				<img src="<?= display_icon($connected_user) ?>" alt="avatar">
			</div>
			<div class="chat-right">
				<form class="post-form" action="/chat" method="post">
                    <textarea class="chat-area" placeholder="Chatter quelque chose..." name="content"
                              maxlength="400"></textarea>
					<div class="chat-form-bottom">
						<button class="chat-image-btn">
							<span class="material-symbols-outlined chat-action-buttons-color">image</span>
						</button>
						<div class="emotions">
							<?php
							for ($i = 1; $i < count(Emotion::cases()) + 1; $i++) {
								?>
								<label>
									<input type="radio" name="emotion" class="emotion"
									       value="<?= $i ?>" <?= $i === 1 ? 'checked' : '' ?> required hidden/>
									<span class="emoji-span twemoji-load"><?= Emotion::cases()[$i - 1]->display() ?></span>
								</label>
								<?php
							}
							?>
						</div>
						<button class="chat-btn" type="submit">Chat</button>
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
				foreach ($posts as $post) {
					require('components/post.php');
				}
			} else {
				?>
				<div class="no-post">
					<p>Il n'y a pas de post pour le moment</p>
				</div>
				<?php
			}
			?>
		</div>
	</div>
<?php
require_once('components/trends.php');
$content = ob_get_clean();
require_once('layout.php');
