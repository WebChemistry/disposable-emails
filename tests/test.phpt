<?php declare(strict_types = 1);

use Tester\Assert;
use WebChemistry\DisposableEmails\EmailChecker;
use WebChemistry\DisposableEmails\Provider\BuiltinProvider;

require __DIR__ . '/bootstrap.php';

$checker = new EmailChecker();
$checker->addProvider(new BuiltinProvider());

Assert::false($checker->isValid('foo@zzz.com'));
Assert::true($checker->isValid('foo@gmail.com'));
Assert::true($checker->isValid('foo'));
Assert::false($checker->isValid('foo', false));

$checker->setValidDomain('zzz.com');

Assert::true($checker->isValid('foo@zzz.com'));

$checker->setInvalidDomain('zzz.com');

Assert::false($checker->isValid('foo@zzz.com'));
