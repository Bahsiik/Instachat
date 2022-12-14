<?php
declare(strict_types=1);

$css[] = 'trends.css';
$js[] = 'trends.js';

global $trends; ?>
<div class="right-bar">
	<div class="search-bar-container">
		<form class="search" action="/get-search-value" method="post">
			<label>
				<input autocomplete="off"
				       maxlength="100"
				       minlength="2"
				       id="search-input"
				       name="search-input"
				       placeholder="Recherche Instachat"
				       required
				       type="text">
			</label>
		</form>
	</div>
	<div class="trends-container">
		<div class="title">
			<h1>Tendances</h1>
		</div>
		<div class="trends-feed">
			<?php
			if (count($trends) > 0) {
				$index = 1;
				foreach ($trends as $name => $count) {
					?>
					<a href="/search-trend?trend=<?= urlencode($name) ?>">
						<button class="trend<?= $index > 5 ? ' hidden' : '' ?>" type="submit">
							<span class="trend-rank"><?= "$index • Tendances" ?></span>
							<span class="trend-content"><?= htmlspecialchars($name) ?></span>
							<span class="trend-number"><?= $count . ' chat' . ($count > 1 ? 's' : '') ?></span>
						</button>
					</a>
					<?php
					$index++;
				}
			} else {
				?>
				<div class="no-trends">
					<h2>Aucune tendance pour le moment</h2>
				</div>
				<?php
			}
			if (count($trends) > 5) {
				?>
				<div class="show-more">
					<button class="show-more-button">Afficher plus</button>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>

