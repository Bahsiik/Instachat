<?php
declare(strict_types=1);

namespace Lib\Utils;

use Model\User;

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
