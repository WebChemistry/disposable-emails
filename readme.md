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
