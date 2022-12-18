<?php

namespace Tests\Feature;

use App\Data\Contoh;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContohServiceProviderTest extends TestCase
{
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function example()
    {
      // $this->app->make(Contoh::class);
      // $this->app->make(Contoh::class);
      self::assertTrue(true);
    }
}
