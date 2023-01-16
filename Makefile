test:
	vendor/bin/tester tests
phpstan:
	vendor/bin/phpstan analyse
domains:
	php build/build.php
