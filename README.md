# My Beers

## Installation

```
$ composer install
$ cp .env .env.local //add your database informations
$ bin/console d:d:c
$ bin/console d:s:u --force
```

## Fixtures

```
$ bin/console d:f:l   // say yes
```

## Test

### PHPUnit

`$ bin/phpunit`

### Behat

`$ java -Dwebdriver.gecko.driver=chromedriver -jar selenium-server-standalone-3.0.1.jar`

`$ bin/behat`

