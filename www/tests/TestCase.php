<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private static $appConfigs = null;

    public function createApplication()
    {
        return self::initialize();
    }

    public function initialize()
    {

        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->loadEnvironmentFrom('.env');
        $app->make(Kernel::class)->bootstrap();

        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        self::$appConfigs = $app;

        return $app;
    }
}
