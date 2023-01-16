<?php declare(strict_types = 1);

namespace WebChemistry\DisposableEmailsBuild;

use LogicException;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\Printer;
use Nette\Utils\FileSystem;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Typertion\Php\TypeAssert;
use WebChemistry\DisposableEmails\Provider\Provider;

final class Generator
{

	/** @var string[] */
	private array $emails = [];

	private HttpClientInterface $httpClient;

	public function __construct()
	{
		$this->httpClient = HttpClient::create();
	}

	public function build(string $namespace, string $className, string $filePath): void
	{
		$file = new PhpFile();
		$file->setStrictTypes();

		$phpNamespace = $file->addNamespace($namespace);
		$phpNamespace->addUse(Provider::class);

		$phpClass = $phpNamespace->addClass($className)
			->setFinal();
		$phpClass->addImplement(Provider::class);

		$phpClass->addMethod('getDomains')
			->setPublic()
			->setReturnType('array')
			->addComment('@return array<string, bool>')
			->addBody('return self::DOMAINS;');

		$emails = array_filter(array_map(trim(...), $this->emails), fn (string $str): bool => $str !== '');
		$emails = array_fill_keys(array_unique($emails), true);

		ksort($emails);

		$phpClass->addConstant('DOMAINS', $emails)
			->setPrivate();

		FileSystem::write($filePath, (new Printer())->printFile($file));
	}

	public function addRemoteText(string $link, string $separator = "\n"): self
	{
		$content = $this->httpClient->request('GET', $link)->getContent();

		if (!$content) {
			throw new LogicException(sprintf('Empty content of %s.', $link));
		}

		$this->emails = array_merge(
			$this->emails,
			explode($separator, $content),
		);

		return $this;
	}

	public function addRemoteJson(string $link): self
	{
		$this->emails = array_merge(
			$this->emails,
			array_map(
				TypeAssert::string(...),
				$this->httpClient->request('GET', $link)->toArray(),
			),
		);

		return $this;
	}

}
