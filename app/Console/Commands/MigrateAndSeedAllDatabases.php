<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MigrateAndSeedAllDatabases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:migrate-seed-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migration and seeding on all databases';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $totalDB = 0;
        $totalSuccess = 0;
        $totalFailure = 0;
        $failedMigrateSeed = [];
        $totalFailedConnections = 0;
        $failedConnections = [];

        // Daftar koneksi database
        $connections = $this->getDatabaseList();

        foreach ($connections as $connectionName => $connectionConfig) {
            $totalDB++;
            if ($this->testDatabaseConnection($connectionConfig)) {
                $this->info("Menghubungkan ke koneksi {$connectionName}...");

                // Menggunakan koneksi langsung dari DB facade
                config(["database.connections.$connectionName" => $connectionConfig]);

                $this->info("Menghubungkan berhasil. Melakukan migrasi dan seeding pada koneksi {$connectionName}...");

                try {
                    // Menjalankan migrasi untuk koneksi saat ini
                    $this->call('migrate', [
                        '--database' => $connectionName,
                        '--force' => true,
                    ]);

                    // Menjalankan seeder untuk koneksi saat ini
                    $this->call('db:seed', [
                        '--class' => 'DatabaseSeeder', // Sesuaikan dengan nama seeder yang diinginkan
                        '--database' => $connectionName,
                        '--force' => true,
                    ]);

                    $totalSuccess++;
                    $this->info("Migrasi dan seeding pada koneksi {$connectionName} selesai.");
                } catch (\Exception $e) {
                    $totalFailure++;
                    $failedMigrateSeed[] = $connectionName;
                    $this->error("Gagal melakukan migrasi dan seeding pada koneksi {$connectionName}: {$e->getMessage()}");
                }
            } else {
                $totalFailedConnections++;
                $failedConnections[] = $connectionName;
                $this->warn("Tidak dapat terhubung ke koneksi {$connectionName}. Melewatkan migrasi dan seeding.");
            }
        }

        $this->info("Migrasi dan seeding pada semua koneksi selesai.");

        $this->info("Total Koneksi: {$totalDB} database");
        $this->info("Total Berhasil: {$totalSuccess}");
        $this->info("Total Gagal: {$totalFailure}");
        $this->info("Total Koneksi yang Gagal: {$totalFailedConnections}");

        // rincian koneksi yang gagal
        if ($totalFailedConnections > 0) {
            $this->warn("Daftar Koneksi yang Gagal: ");
            foreach ($failedConnections as $connectionName) {
                $this->warn(" - {$connectionName}");
            }
        }
        // rincian migrasi dan seeding yang gagal
        if ($totalFailure > 0) {
            $this->warn("Daftar Migrasi dan Seeding yang Gagal: ");
            foreach ($failedMigrateSeed as $connectionName) {
                $this->warn(" - {$connectionName}");
            }
        }
    }

    protected function testDatabaseConnection($connectionConfig)
    {
        // connection to database postgres try catch
        try {
            $sslmode = isset($connectionConfig['sslmode']) ? " sslmode={$connectionConfig['sslmode']}" : "";
            $connection = pg_connect("host={$connectionConfig['host']} port={$connectionConfig['port']} dbname={$connectionConfig['database']} user={$connectionConfig['username']} password={$connectionConfig['password']}{$sslmode}");
            if ($connection) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function getDatabaseList()
    {
        // Daftar koneksi database
        $connections = [
            // local
            'local' => [
                'driver' => 'pgsql',
                'host' => '127.0.0.1',
                'port' => '5432',
                'database' => 'aristoteles-sim-db',
                'username' => 'postgres',
                'password' => '0707',
            ],
            // // demo
            // 'demo' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'emagazine-sim-demo-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // aristoteles
            // 'aristoteles' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'aristoteles-sim-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // sman1rotebarat
            // 'sman1rotebarat' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'emagazine-sim-sman1rotebarat-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // smpirgt
            // 'smpirgt' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'emagazine-sim-smpirgt-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // sdirgt
            // 'sdirgt' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'emagazine-sim-sdirgt-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // smkbopkri1yk
            // 'smkbopkri1yk' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'emagazine-sim-smkbopkri1yk-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // itqan
            // 'itqan' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'emagazine-sim-itqan-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // smabhaone
            // 'smabhaone' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'emagazine-sim-smabhaone-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // simak
            // 'simak' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'emagazine-sim-simak-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // smamaryamsby
            // 'smamaryamsby' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'emagazine-sim-smamaryamsby-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // smanaga
            // 'smanaga' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'smanaga-sim-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // smaskasansta
            // 'smaskasansta' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'emagazine-sim-smaskasansta-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // smkketintang
            // 'smkketintang' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'emagazine-sim-smkketintang-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
            // // littlesunschool
            // 'littlesunschool' => [
            //     'driver' => 'pgsql',
            //     'host' => '167.172.95.149',
            //     'port' => '5432',
            //     'database' => 'emagazine-sim-littlesunschool-db',
            //     'username' => 'superadmin',
            //     'password' => 'gaeLik6aeshie0equooxieVeiThahN',
            // ],
        ];

        return $connections;
    }
}
