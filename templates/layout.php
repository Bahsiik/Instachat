<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta
			name="viewport"
			content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
		>
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" href="../static/images/logo.png">
		<link rel="stylesheet" href="../static/styles/style.css">
		<link rel="stylesheet" href="../static/styles/colors/orange.css">
		<link rel="stylesheet" href="../static/styles/background/gray.css">
		<?php if (isset($css)) {
			foreach ($css as $cssFile) { ?>
				<link rel="stylesheet" href="../static/styles/<?= $cssFile ?>">
			<?php }
		} ?>
        <?php if(isset($js)) {
            foreach ($js as $jsFile) { ?>
                <script defer src="../static/scripts/<?= $jsFile ?>"></script>
            <?php }
        } ?>
		<title><?= $title ?? '' ?></title>
        <script crossorigin="anonymous" src="https://kit.fontawesome.com/74fed0e2b5.js"></script>
        <script src="https://twemoji.maxcdn.com/v/14.0.2/twemoji.min.js" integrity="sha384-32KMvAMS4DUBcQtHG6fzADguo/tpN1Nh6BAJa2QqZc6/i0K+YPQE+bWiqBRAWuFs" crossorigin="anonymous"></script>
	</head>
	<body>
		<?= $content ?? '' ?>
	</body>
    <script defer>twemoji.parse(document.body)</script>
</html>
