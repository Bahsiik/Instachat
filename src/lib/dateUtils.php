<?php
declare(strict_types=1);


/**
 * @param DateTime $date
 * @return void
 */
function format_date_time(DateTime $date): void {
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
		echo $date_only_formatter->format($date);
	} else if ($diff->h > 0) {
		echo $diff->h . ' h';
	} else if ($diff->i > 0) {
		echo $diff->i . ' min';
	} else if ($diff->s >= 0) {
		echo $diff->s . 's';
	}
}