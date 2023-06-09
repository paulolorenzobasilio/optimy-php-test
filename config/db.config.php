<?php

/**
 * Configure database connection and schema
 * Check https://cycle-orm.dev/
 */

use Cycle\Database;
use Cycle\Database\Config;
use Cycle\Schema;
use Cycle\Annotated;
use Cycle\ORM;

$dbal = new Database\DatabaseManager(new Config\DatabaseConfig([
    'default' => 'default',
    'databases' => [
        'default' => ['connection' => 'mysql']
    ],
    'connections' => [
        'mysql' => new Config\MySQLDriverConfig(
            connection: new Config\MySQL\DsnConnectionConfig(
                dsn: $_ENV['DB_HOST'],
                user: $_ENV['DB_USER'],
                password: $_ENV['DB_PASSWORD']
            ), queryCache: true
        )
    ]
]));

$orm = new ORM\ORM(new ORM\Factory($dbal), new ORM\Schema([]));

$finder = (new Symfony\Component\Finder\Finder())->files()->in('src/Class');
$classLocator = new \Spiral\Tokenizer\ClassLocator($finder);

$schema = (new Schema\Compiler())->compile(new Schema\Registry($dbal), [
    new Schema\Generator\ResetTables(),             // re-declared table schemas (remove columns)
    new Annotated\Embeddings($classLocator),        // register embeddable entities
    new Annotated\Entities($classLocator),          // register annotated entities
    new Annotated\TableInheritance(),               // register STI/JTI
    new Annotated\MergeColumns(),                   // add @Table column declarations
    new Schema\Generator\GenerateRelations(),       // generate entity relations
    new Schema\Generator\GenerateModifiers(),       // generate changes from schema modifiers
    new Schema\Generator\ValidateEntities(),        // make sure all entity schemas are correct
    new Schema\Generator\RenderTables(),            // declare table schemas
    new Schema\Generator\RenderRelations(),         // declare relation keys and indexes
    new Schema\Generator\RenderModifiers(),         // render all schema modifiers
    new Annotated\MergeIndexes(),                   // add @Table column declarations
    new Schema\Generator\SyncTables(),              // sync table changes to database
    new Schema\Generator\GenerateTypecast(),        // typecast non string columns
]);
$orm = $orm->with(schema: new ORM\Schema($schema));
$entityManager = new ORM\EntityManager($orm);

return [$orm, $entityManager];
