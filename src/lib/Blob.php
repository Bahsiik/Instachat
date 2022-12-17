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

	/**
	 * toBase64 is the function that converts the blob to base64
	 * @return string - the base64 of the blob
	 */
	public function toLink(): string {
		return "data:image/png;base64,{$this->toBase64()}";
	}

	/**
	 * toBase64 is the function that converts the blob to base64
	 * @return string - the base64 of the blob
	 */
	public function toBase64(): string {
		return base64_encode($this->data);
	}
}