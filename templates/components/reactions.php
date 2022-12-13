<?php
declare(strict_types=1);

global $reactions;
?>
<div class="reactions">
	<?php
	foreach ($reactions as $reaction) {
		echo $reaction->display();
	}
	?>
</div>
