# Disposable emails checker

Installation:
```bash
composer require webchemistry/disposable-emails
```

Usage:

```php
$checker = new EmailChecker();
$checker->addProvider(new BuiltinProvider());

assert($checker->isValid('foo@zzz.com'));
```

Credits: \
https://raw.githubusercontent.com/MattKetmo/EmailChecker/master/res/throwaway_domains.txt \
https://raw.githubusercontent.com/ivolo/disposable-email-domains/master/wildcard.json \
https://raw.githubusercontent.com/disposable-email-domains/disposable-email-domains/master/disposable_email_blocklist.conf
