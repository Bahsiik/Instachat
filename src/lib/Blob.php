<?php
declare(strict_types=1);

namespace Utils;

/**
 * Class Blob is a class that represents a blob
 * @package Utils
 */
class Blob {
	/**
	 * @var string $data - the data of the blob
	 */
	public function __construct(
		public readonly string $data,
	) {}
}
