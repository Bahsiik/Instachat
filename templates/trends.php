<?php

$css[] = 'trends.css';
$js[] = 'trends.js';
?>
<?php
global $trends; ?>
	<div class="trends-container">
		<div class="title">
			<h1>Tendances</h1>
		</div>
		<div class="trends-feed">
			<?php
			$index = 1;
			foreach ($trends as $name => $count) {
				if ($index < 6) {
					?>
					<div class="trend">
						<div class="trend-rank">
							<p><?= $index . ' • Tendances' ?></p>
						</div>
						<div class="trend-content">
							<p><?= $name ?></p>
						</div>
						<div class="trend-number">
							<p><?= $count . ' chat' . ($count > 1 ? 's' : '') ?></p>
						</div>
					</div>
					<?php
				} else {
					?>
					<div class="trend hidden">
						<div class="trend-rank">
							<p><?= $index . ' • Tendances' ?></p>
						</div>
						<div class="trend-content">
							<p><?= $name ?></p>
						</div>
						<div class="trend-number">
							<p><?= $count . ' chat' . ($count > 1 ? 's' : '') ?></p>
						</div>
					</div>
					<?php
				}
				$index++;
			}
			?>
			<div class="show-more">
				<button class="show-more-button" onclick="changeTrendsDisplay()">Afficher plus</button>
			</div>
		</div>
	</div>
<?php
$content = ob_get_clean();
require_once('layout.php');
