<?php
declare(strict_types=1);

namespace Lib\Utils;

use Models\User;

const LOGO_LINK = '/static/images/logo-';

function display_icon(?User $user = null): string {
	return LOGO_LINK . ($user === null ? 'orange' : $user->color->lowercaseName()) . '.png';
}

function redirect(string $url): never {
	header("Location: $url");
	exit();
}

function redirect_if_method_not(string $route_type, string $url): void {
	if ($_SERVER['REQUEST_METHOD'] !== $route_type) redirect($url);
}

function selectToolbarItem(string $route): string {
	return $_SERVER['REQUEST_URI'] === $route ? 'toolbar-item-selected' : '';
}

function writeLog(string $page_name, string $extra_content = ''): string {
	global $connected_user;
	$user = $connected_user === null ? 'UNKNOWN' : $connected_user->username;
	$date = date('Y-m-d H:i:s');
	$method = $_SERVER['REQUEST_METHOD'];
	$uri = $_SERVER['REQUEST_URI'];
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	return "[$date] [$page_name] [$user:$ip_addr] : $method $uri $extra_content \n";
}