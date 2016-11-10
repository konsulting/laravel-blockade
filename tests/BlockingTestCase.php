<?php

namespace Konsulting\Laravel\Blockade;

use Route;
use Schema;

abstract class BlockingTestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Set up ServiceProviders
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [BlockadeServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('blockade.code', 'abc');
        $app['config']->set('blockade.not_blocked', ['not-blocked']);

        $app->make('Illuminate\Contracts\Http\Kernel')
            ->pushMiddleware(IsBlocked::class);

        Route::group([
            'middleware' => ['web'],
        ], function ($router) {
            Route::get('/', function () { return 'Home'; })->name('home');
            Route::get('/not-blocked', function () { return 'Not Blocked'; })->name('not-blocked');
        });
    }
}
