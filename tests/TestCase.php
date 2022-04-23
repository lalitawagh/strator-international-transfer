<?php

namespace Kanexy\InternationalTransfer\Tests;

use AmrShawky\LaravelCurrency\CurrencyServiceProvider;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Kanexy\Cms\CmsServiceProvider;
use Kanexy\InternationalTransfer\InternationalTransferServiceProvider;
use Livewire\LivewireServiceProvider;
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
            CmsServiceProvider::class,
            LivewireServiceProvider::class,
            CurrencyServiceProvider::class
        ];
    }

    public function getEnvironmentSetUp($app)
    {

        $app['config']->set('view.paths', [
            __DIR__.'/views',
            resource_path('views'),
        ]);

        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');

        $app['config']->set('database.connections.mysql', [
            'driver'   => 'mysql',
            'database' => 'kanexyv1',
            'prefix'   => '',
            'host' => '127.0.0.1',
            'username'=> 'root',
            'password' => ''
        ]);
    }
}
