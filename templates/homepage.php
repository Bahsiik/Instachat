<?php use Model\Emotion;

$css = ['homepage.css'];
$title = 'Instachat';

ob_start();
require_once('toolbar.php');
?>
	<div class="chat-container">
		<form action="/chat" method="post">
			<input name="content" placeholder="Chatter quelque chose..." required type="text">
			<button type="button"><i class="fa-regular fa-image"></i></button>
			<div class="emotions">
				<?php
				for ($i = 1; $i < count(Emotion::cases()) + 1; $i++) {
					?>
					<label>
						<input type="radio" name="emotion" class="emotion" value="<?= $i ?>" <?= $i === 1 ? 'checked' : '' ?> required hidden/>
						<span><?= Emotion::cases()[$i - 1]->display() ?></span>
					</label>
					<?php
				}
				?>
			</div>
			<button type="submit">Chat</button>
		</form>
	</div>
<?php
$content = ob_get_clean();
require_once('layout.php');
