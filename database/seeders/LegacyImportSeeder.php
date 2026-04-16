<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LegacyImportSeeder extends Seeder
{
    /**
     * Tables to migrate from legacy sqlite to MySQL.
     *
     * @var string[]
     */
    protected array $tables = [
        'users',
        'assets',
        'loans',
        'site_settings',
    ];

    public function run(): void
    {
        $legacy = DB::connection('legacy_sqlite');
        $mysql = DB::connection();

        $mysql->statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($this->tables as $table) {
            if (!Schema::connection('legacy_sqlite')->hasTable($table) || !Schema::hasTable($table)) {
                $this->command?->warn("Skipping {$table}, table not found in one of the connections.");
                continue;
            }

            $this->command?->info("Migrating {$table}...");
            $mysql->table($table)->truncate();

            $legacy->table($table)->orderBy('id')->chunk(500, function ($chunk) use ($mysql, $table) {
                $payload = array_map(function ($row) {
                    $array = (array) $row;
                    unset($array['password_confirmation']);
                    return $array;
                }, $chunk->all());

                if (!empty($payload)) {
                    $mysql->table($table)->insert($payload);
                }
            });
        }

        $mysql->statement('SET FOREIGN_KEY_CHECKS=1');
        $this->command?->info('Legacy data import completed.');
    }
}
