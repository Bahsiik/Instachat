<?php
declare(strict_types=1);

use function Lib\Utils\display_icon;



?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta
			name="viewport"
			content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
		>
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel='icon' href='<?= display_icon($connected_user ?? null) ?>'>
		<link rel='stylesheet' href='/static/styles/style.css'>
		<script defer type="module" src="/static/scripts/navbar.js"></script>

		<?php
		global $connected_user;
		if ($connected_user === null) {
			array_unshift($css, 'colors/orange.css', 'background/gray.css');
		} else {
			array_unshift($css, "colors/{$connected_user->color->lowercaseName()}.css", "background/{$connected_user->background->lowercaseName()}.css");
		}

		foreach ($css as $css_file) { ?>
			<link rel="stylesheet" href="/static/styles/<?= $css_file ?>">
			<?php
		}

		if (isset($js)) {
			foreach ($js as $js_file) { ?>
				<script defer type="module" src="/static/scripts/<?= $js_file ?>"></script>
				<?php
			}
		}
		?>
		<title>Instachat | <?= $title ?? '' ?></title>
		<script crossorigin="anonymous" src="https://kit.fontawesome.com/74fed0e2b5.js"></script>
		<script
			crossorigin="anonymous"
			integrity="sha384-32KMvAMS4DUBcQtHG6fzADguo/tpN1Nh6BAJa2QqZc6/i0K+YPQE+bWiqBRAWuFs"
			src="https://twemoji.maxcdn.com/v/14.0.2/twemoji.min.js"
		></script>
		<script>
			document.addEventListener('DOMContentLoaded', () => twemoji.parse(document.body));
		</script>
	</head>
	<body>
		<?= $content ?? '' ?>
	</body>
</html>
