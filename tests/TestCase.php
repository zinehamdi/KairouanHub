<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->afterApplicationCreated(function(){
            if (class_exists(\Spatie\Permission\Models\Role::class)) {
                try {
                    \Spatie\Permission\Models\Role::firstOrCreate(['name'=>'admin']);
                    \Spatie\Permission\Models\Role::firstOrCreate(['name'=>'client']);
                    \Spatie\Permission\Models\Role::firstOrCreate(['name'=>'provider']);
                } catch (\Throwable $e) {
                    // ignore if roles table not migrated yet
                }
            }
        });
    }
}
