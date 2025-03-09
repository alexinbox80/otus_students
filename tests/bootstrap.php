<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env.test');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

// executes the "php bin/console cache:clear" command
passthru(sprintf(
    'APP_ENV=%s php "%s/../bin/console" cache:clear --no-warmup',
    $_ENV['APP_ENV'],
    __DIR__
    ));

// executes the "php bin/console doctrine:schema:drop --full-database --force --env=test" command
passthru(sprintf(
    'APP_ENV=%s php "%s/../bin/console" doctrine:schema:drop --full-database --force --env=test',
    $_ENV['APP_ENV'],
    __DIR__
));

// executes the "php bin/console doctrine:migrations:migrate --no-interaction --env=test" command
passthru(sprintf(
    'APP_ENV=%s php "%s/../bin/console" doctrine:migrations:migrate --no-interaction --env=test',
    $_ENV['APP_ENV'],
    __DIR__
));
