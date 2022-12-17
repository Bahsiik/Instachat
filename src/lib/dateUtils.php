<?php
declare(strict_types=1);

/**
 * format_date_time_diff is the function that formats a date time diff
 * @param DateTime $date - the date to format
 * @param string $prefix - the prefix of the date
 * @return void - echo the formatted date
 */
function format_date_time_diff(DateTime $date, string $prefix = ''): void {
	$current_date = new DateTime();
	$diff = $current_date->diff($date);
	$date_only_formatter = IntlDateFormatter::create(
		'fr_FR',
		IntlDateFormatter::FULL,
		IntlDateFormatter::FULL,
		'Europe/Paris',
		IntlDateFormatter::GREGORIAN,
		'd MMMM yyyy'
	);

	if ($diff->days > 0) {
		echo $prefix . $date_only_formatter->format($date);
	} else if ($diff->h > 0) {
		echo $diff->h . ' h';
	} else if ($diff->i > 0) {
		echo $diff->i . ' min';
	} else if ($diff->s >= 0) {
		echo $diff->s . 's';
	}
}

/**
 * format_date_time is the function that formats a date
 * @param DateTime $date - the date to format
 * @return void - echo the formatted date
 */
function format_date_time(DateTime $date): void {
	$date_only_formatter = IntlDateFormatter::create(
		'fr_FR',
		IntlDateFormatter::FULL,
		IntlDateFormatter::FULL,
		'Europe/Paris',
		IntlDateFormatter::GREGORIAN,
		'd MMMM yyyy'
	);

	echo $date_only_formatter->format($date);
}

/**
 * format_date_time_full is the function that formats a date & time
 * @param DateTime $date - the date to format
 * @return void - echo the formatted date
 */
function format_date_time_full(DateTime $date): void {
	$date_only_formatter = IntlDateFormatter::create(
		'fr_FR',
		IntlDateFormatter::FULL,
		IntlDateFormatter::FULL,
		'Europe/Paris',
		IntlDateFormatter::GREGORIAN,
		'd MMMM yyyy à H:mm:ss'
	);

	echo $date_only_formatter->format($date);
}
