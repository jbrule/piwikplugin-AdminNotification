# Running tests

## PHPStan

Go to AdminNotification plugin dir:

```bash
composer install
```

Go to Matomo root (/var/www/html usually) run:

```bash
/var/www/html/plugins/AdminNotification/vendor/bin/phpstan analyze -c /var/www/html/plugins/AdminNotification/tests/phpstan.neon --level=1 /var/www/html/plugins/AdminNotification
```

## PHPCS

Go to AdminNotification plugin dir:

```bash
composer install
```

Run PHP Codesniffer

```bash
vendor/bin/phpcs --ignore=*/vendor/*  --standard=PSR2 .
```
