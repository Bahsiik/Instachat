<?php
declare(strict_types=1);

$css[] = 'searchtrend.css';
$css[] = 'post.css';

ob_start();
require_once('toolbar.php');

global $searched_posts;
global $searched_trend;
?>

	<div class="searched-trend-container">
		<div class="title">
			<h1>Tendances - <?= htmlspecialchars($searched_trend) ?></h1>
		</div>
		<div class="searched-trend-feed">
			<?php
			if (count($searched_posts) > 0) {
				global $post;
				foreach ($searched_posts as $post) {
					require('post.php');
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

<?php
require_once('trends.php');
$content = ob_get_clean();
require_once('layout.php');