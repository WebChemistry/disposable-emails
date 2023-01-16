<?php declare(strict_types = 1);

namespace WebChemistry\DisposableEmails;

use WebChemistry\DisposableEmails\Provider\Provider;

final class EmailChecker
{

	/** @var array<string, bool> */
	private array $domains = [];

	private bool $valueIfMissingAt = true;

	public function setInvalidDomain(string $domain): self
	{
		$this->domains[$domain] = true;

		return $this;
	}

	public function setValidDomain(string $domain): self
	{
		unset($this->domains[$domain]);

		return $this;
	}

	public function setValueIfMissingAt(bool $valueIfMissingAt): self
	{
		$this->valueIfMissingAt = $valueIfMissingAt;

		return $this;
	}

	public function addProvider(Provider $provider): self
	{
		$this->domains = array_merge($this->domains, $provider->getDomains());

		return $this;
	}

	public function isValid(string $email, ?bool $valueIfMissingAt = null): bool
	{
		$pos = strrpos($email, '@');

		if ($pos === false) {
			return $valueIfMissingAt ?? $this->valueIfMissingAt;
		}

		return !isset($this->domains[substr($email, $pos + 1)]);
	}

}
