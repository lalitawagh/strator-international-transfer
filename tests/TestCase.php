<?php

namespace Kanexy\InternationalTransfer\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kanexy\InternationalTransfer\InternationalTransferServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;


class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Kanexy\\InternationalTransfer\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            InternationalTransferServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        include_once __DIR__.'/../database/migrations/create_plans_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
