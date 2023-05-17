<?php

use Cycle\ORM;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

[$orm, $entityManager] = require_once 'config/db.config.php';

/**
 * Injects needed dependency.
 *
 * all our directory classes are configured autowire however for third party classes you need to inject them
 * expect to have loads of data for container configuration
 *
 * https://php-di.org/doc/container-configuration.html
 */
$container = new DI\Container([
    ORM\ORMInterface::class => DI\factory(function() use ($orm){
       return $orm;
    }),
    ORM\EntityManagerInterface::class => DI\factory(function () use ($entityManager){
        return $entityManager;
    })
]);

return ['container' => $container];
