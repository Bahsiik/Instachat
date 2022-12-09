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
			<div class="trend<?= $index > 5 ? ' hidden' : '' ?>">
				<div class="trend-rank">
					<p><?= "$index • Tendances" ?></p>
				</div>
				<div class="trend-content">
					<p><?= htmlspecialchars($name) ?></p>
				</div>
				<div class="trend-number">
					<p><?= $count . ' chat' . ($count > 1 ? 's' : '') ?></p>
				</div>
			</div>
			<?php
			$index++;
		}
		?>
		<div class="show-more">
			<button class="show-more-button" onclick="changeTrendsDisplay()">Afficher plus</button>
		</div>
	</div>
</div>
