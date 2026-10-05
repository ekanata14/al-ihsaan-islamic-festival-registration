<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Pengaman: RefreshDatabase menjalankan `migrate:fresh`. Pastikan tes
     * benar-benar berjalan di SQLite in-memory agar database MySQL (dev)
     * tidak pernah terhapus.
     */
    protected function setUp(): void
    {
        $connection = getenv('DB_CONNECTION')
            ?: ($_ENV['DB_CONNECTION'] ?? $_SERVER['DB_CONNECTION'] ?? null);

        if ($connection !== 'sqlite') {
            $this->fail(sprintf(
                'Test DB tidak terisolasi (DB_CONNECTION="%s"). Set DB_CONNECTION=sqlite dan DB_DATABASE=:memory: agar data MySQL tidak terhapus.',
                (string) $connection
            ));
        }

        parent::setUp();
    }
}
