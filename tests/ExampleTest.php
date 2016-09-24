<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('A navigation bar is a navigation header that is placed at the top of the page.');
    }

    public function testNewUserRegistration()
    {
        $this->visit('/')
             ->type('', 'name')
             ->uncheck('terms');
    }
}
