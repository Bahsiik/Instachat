<?php
declare(strict_types=1);

namespace Utils;

class Blob {
	public function __construct(
		public readonly string $data,
	) {}

	public function toLink(): string {
		return "data:image/png;base64,{$this->toBase64()}";
	}

	public function toBase64(): string {
		return base64_encode($this->data);
	}
}