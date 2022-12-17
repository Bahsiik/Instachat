<?php
declare(strict_types=1);

namespace Lib;

use InvalidArgumentException;

/**
 * Class UserException - Exception thrown whenever needed
 * Example : An invalid argument is passed to a controller
 * It will be caught by the error handler and displayed to the user
 */
class UserException extends InvalidArgumentException {
	/**
	 * UserException constructor.
	 * @param string $message - The message to display to the user
	 */
	public function __construct(string $message, int $code = 0) {
		parent::__construct($message, $code);
	}
}
