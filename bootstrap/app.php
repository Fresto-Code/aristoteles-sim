<?php

use Illuminate\Support\Facades\DB;
use Dotenv\Dotenv;

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

// version ringkas
$environmentFiles = [
    'aristoteles-sim.test' => '.env',
    'emagazine-sman1rotebarat.afresto.id' => '.env.sman1rotebarat',
    'emagazine-sdirgt.afresto.id' => '.env.sdirgt',
    'emagazine-smpirgt.afresto.id' => '.env.smpirgt',
    'emagazine.donbosko133.sch.id' => '.env.donbosko133',
];

$host = $_SERVER['HTTP_HOST'] ?? 'aristoteles-sim.test';

// Cek apakah domain terkait dengan environment khusus
if (array_key_exists($host, $environmentFiles)) {
    $environmentFile = $environmentFiles[$host];
} else {
    $environmentFile = '.env';
}

// Load main environment variables from .env.config
// $dotenv = Dotenv::createMutable(base_path(), '.env.config');
// $dotenv->load();

// Load main environment variables dari .env.config jika ada
$dotenvConfigPath = base_path('.env.config');
if (file_exists($dotenvConfigPath)) {
    $dotenv = Dotenv::createMutable(base_path(), '.env.config');
    $dotenv->load();
}

// Load environment variables specific to the host
$envFilePath = base_path($environmentFile);
if (file_exists($envFilePath)) {
    $dotenv = Dotenv::createMutable(base_path(), $environmentFile);
    $dotenv->load();
}

// // Load environment variables
// $envFilePath = base_path($environmentFile);
// if (file_exists($envFilePath)) {
//     $dotenv = Dotenv\Dotenv::createMutable(base_path(), $environmentFile);
//     $dotenv->load();
//     // DB::purge('mysq');
// }

//

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
