<?php

namespace Konsulting\Laravel\Blockade;

use Route;
use Schema;

abstract class SecuringTestCase extends \Orchestra\Testbench\TestCase
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

        $app['config']->set('blockade.not_secure', ['not-secure']);

        $app->make('Illuminate\Contracts\Http\Kernel')
            ->pushMiddleware(ForceSecure::class);

        Route::group([
            'middleware' => ['web'],
        ], function ($router) {
            Route::get('/not-secure', function () { return 'Not Secure'; })->name('not-secure');
            Route::get('/secure', function () { return 'Secure'; })->name('secure');
        });
    }
}
