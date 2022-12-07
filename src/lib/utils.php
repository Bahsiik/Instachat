<?php

namespace Src\Lib\Utils;

function redirect(string $url): never {
	header("Location: $url");
	exit();
}

function redirect_if_method_not(string $route_type, string $url): void {
	if ($_SERVER['REQUEST_METHOD'] !== $route_type) redirect($url);
}
