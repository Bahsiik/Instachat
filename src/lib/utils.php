<?php
declare(strict_types=1);

namespace Lib\Utils;

use Controllers\Blocked\GetBlockedUsers;
use Controllers\Blocked\GetBlockedWords;
use Controllers\Blocked\GetUsersThatBlocked;
use Models\User;
use function file_put_contents;
use const FILE_APPEND;

const LOGO_LINK = '/static/images/logo-';

/**
 * display_icon is a function that displays the icon of the website depending on the user theme
 * @param ?User $user - the user
 * @return string - the link to the icon
 */
function display_icon(?User $user = null): string {
	return LOGO_LINK . ($user === null ? 'orange' : $user->color->lowercaseName()) . '.png';
}

/**
 * redirect is a function that redirects to a page
 * @param string $url - the link to redirect to
 * @return never - redirects to the link
 */
function redirect(string $url): never {
	header("Location: $url");
	exit();
}

/**
 * redirect_if_method_not is a function that redirects to a page if the method is not the one specified
 * @param string $method - the method to check
 * @param string $url - the link to redirect to
 * @return void - redirects to the link
 */
function redirect_if_method_not(string $method, string $url): void {
	if ($_SERVER['REQUEST_METHOD'] !== $method) redirect($url);
}

/**
 * selectToolbarItem is a function that selects the toolbar item
 * @param string $route - the route to check
 * @return string - the class of the item
 */
function select_toolbar_item(string $route): string {
	return $_SERVER['REQUEST_URI'] === $route ? 'toolbar-item-selected' : '';
}

const LOG_FILE = 'log.txt';

/**
 * writeLog is a function that writes a log
 * @param string $page_name - the name of the page
 * @param string $extra_content - the extra content to write
 * @return void - writes the log
 */
function write_log(string $page_name, string $extra_content = ''): void {
	global $connected_user;
	$user = $connected_user === null ? 'UNKNOWN' : $connected_user->username;
	$date = date('Y-m-d H:i:s');
	$method = $_SERVER['REQUEST_METHOD'];
	$uri = $_SERVER['REQUEST_URI'];
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	$data = "[$date] [$page_name] [$user:$ip_addr] : $method $uri $extra_content \n";
	file_put_contents(LOG_FILE, $data, FILE_APPEND);
}

/**
 * filter_blocked_posts is a function that filters the posts with the blocked words and users
 * @param User $connected_user - the connected user
 * @param array $posts - the posts to filter
 * @return array - the filtered posts
 */
function filter_blocked_posts(User $connected_user, array $posts): array {
	$blocked_words = (new GetBlockedWords())->execute($connected_user);
	$blocked_users = (new GetBlockedUsers())->execute($connected_user);
	$users_that_blocked = (new GetUsersThatBlocked())->execute($connected_user);

	foreach ($posts as $post) {
		foreach ($blocked_words as $blocked_word) {
			if ($post->authorId !== $connected_user->id && mb_stripos(mb_strtolower($post->content), mb_strtolower($blocked_word->blockedWord)) !== false) {
				unset($posts[array_search($post, $posts, true)]);
			}
		}

		foreach ($blocked_users as $blocked_user) {
			if ($post->authorId === $blocked_user->blockedId) {
				unset($posts[array_search($post, $posts, true)]);
			}
		}

		foreach ($users_that_blocked as $user_that_blocked) {
			if ($post->authorId === $user_that_blocked->blockerId) {
				unset($posts[array_search($post, $posts, true)]);
			}
		}
	}
	return $posts;
}
