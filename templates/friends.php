<?php
declare(strict_types=1);

$css[] = 'homepage.css';
$title = 'Instachat';

ob_start();
require_once('toolbar.php');
$content = ob_get_clean();
require_once('layout.php');
