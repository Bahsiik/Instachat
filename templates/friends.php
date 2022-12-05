<?php use Model\Emotion;

$css = ['homepage.css'];
$title = 'Instachat';

ob_start();
require_once('toolbar.php');
$content = ob_get_clean();
require_once('layout.php');