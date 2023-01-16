<?php declare(strict_types = 1);

use WebChemistry\DisposableEmailsBuild\Generator;

require __DIR__ . '/../vendor/autoload.php';

(new Generator())
	->addRemoteText('https://raw.githubusercontent.com/MattKetmo/EmailChecker/master/res/throwaway_domains.txt')
	->addRemoteJson('https://raw.githubusercontent.com/ivolo/disposable-email-domains/master/wildcard.json')
	->addRemoteText('https://raw.githubusercontent.com/disposable-email-domains/disposable-email-domains/master/disposable_email_blocklist.conf')
	->build('WebChemistry\DisposableEmails\Provider', 'BuiltinProvider', __DIR__ . '/../src/Provider/BuiltinProvider.php');
