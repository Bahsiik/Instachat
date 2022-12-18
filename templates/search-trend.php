<?php
declare(strict_types=1);

$css = ['search-trend.css', 'reaction.css'];
$js = ['posts.js'];

ob_start();
require_once 'components/navbar.php';

global $searched_posts, $searched_trend;

$title = "Tendances : $searched_trend";
?>
	<main class="searched-trend-container">
		<div class="title">
			<h1>Tendances - <?= htmlspecialchars($searched_trend) ?></h1>
		</div>
		<div class="searched-trend-feed">
			<?php
			if (count($searched_posts) > 0) {
				global $post;
				foreach ($searched_posts as $post) {
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
	</main>
<?php
require_once 'components/trends.php';
$content = ob_get_clean();
require_once 'layout.php';
