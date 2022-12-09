<?php
declare(strict_types=1);

$css[] = 'trends.css';
$js[] = 'trends.js';

global $trends; ?>
<div class="trends-container">
	<div class="title">
		<h1>Tendances</h1>
	</div>
	<div class="trends-feed">
		<?php
		$index = 1;
		foreach ($trends as $name => $count) {
			?>
			<form action="/search-trend" method="post">
				<input type="hidden" name="trend" value="<?= $name ?>">
				<button class="trend<?= $index > 5 ? ' hidden' : '' ?>" type="submit">
					<span class="trend-rank"><?= "$index • Tendances" ?></span>
					<span class="trend-content"><?= htmlspecialchars($name) ?></span>
					<span class="trend-number"><?= $count . ' chat' . ($count > 1 ? 's' : '') ?></span>
				</button>
			</form>
			<?php
			$index++;
		}
		?>
		<div class="show-more">
			<button class="show-more-button" onclick="changeTrendsDisplay()">Afficher plus</button>
		</div>
	</div>
</div>