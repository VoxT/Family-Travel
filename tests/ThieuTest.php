<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThieuTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBrand()
    {
        $this->visit('/')
             ->see('Family Travel');
    }
}
