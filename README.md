# My Beers

## Installation

```
$ composer install
$ cp .env .env.local //add your database informations
$ bin/console d:d:c
$ bin/console d:s:u --force
$ bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json
$ yarn install
$ yarn watch
```

## Fixtures

```
$ bin/console d:f:l   // say yes
```

## Test

### PHPUnit

`$ bin/phpunit`

### Behat

`$ java -Dwebdriver.gecko.driver=chromedriver -jar selenium-server-standalone-3.141.59.jar`

`$ bin/behat`

