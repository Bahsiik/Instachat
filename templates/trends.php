<?php
use Controllers\Post\GetComments;
use Model\Emotion;

$css = ['trends.css'];
$title = 'Instachat';

ob_start();
?>
	<div class="trends-container">
		<div class="title">
			<h1>Tendances</h1>
		</div>
		<div class="trends-feed">
			<div class="trend">
				<div class="trend-rank">
					<p>1 • Tendances</p>
				</div>
				<div class="trend-content">
					<p>Instachat</p>
				</div>
				<div class="trend-number">
					<p>16.9K Chats</p>
				</div>
			</div>
			<div class="show-more">
				<button>Afficher plus</button>
			</div>
		</div>
	</div>
<?php
$content = ob_get_clean();
require_once('layout.php');
