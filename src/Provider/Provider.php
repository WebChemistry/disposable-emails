<?php declare(strict_types = 1);

namespace WebChemistry\DisposableEmails\Provider;

interface Provider
{

	/**
	 * @return array<string, bool>
	 */
	public function getDomains(): array;

}
