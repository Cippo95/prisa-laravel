<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class AuthenticationTest extends DuskTestCase
{
    public function setUp(): void
    {
        $this->appUrl = env('APP_URL');
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed DatabaseSeeder');
    }

    /**
     * A basic browser test example.
     *
     * @return void
     */
    // public function test_login()
    // {
    //     $user = User::factory()->create([
    //         'email' => 'taylor@laravel.com',
    //     ]);

    //     $this->browse(function ($browser) use ($user) {
    //         $browser->visit('/login')
    //                 ->type('email', $user->email)
    //                 ->type('password', 'password')
    //                 ->press('Login')
    //                 ->assertPathIs('/home');
    //     });
    // }

    public function test_project_ownership()
    {
        $this->browse(function ($first,$second) {
            //first user enters, user 1 is a student
            $first->loginAs(User::find(1))
                    //visit home
                    ->visit('/home')
                    //click to see projects
                    ->clickLink('Clicca qui per controllare i tuoi progetti')
                    //click to add a project
                    ->clickLink('Clicca qui per aggiungere un nuovo progetto')
                    //select the first course
                    ->select('course')
                    //write a message
                    ->type('message','hello world')
                    //post
                    ->press('Invia');
                    //test di allegato
            //second user enters, user 2 is a student
            $second->loginAs(User::find(2))
                    ->visit('/home')
                    ->clickLink('Clicca qui per controllare i tuoi progetti')
                    //screenshot to debug
                    ->screenshot('no_projects')
                    ->assertSee('Non ci sono progetti da mostrare.')
                    ->visit('/users/'.User::find(1)->id.'/projects')
                    ->screenshot('no_ownership')
                    ->assertSee('FORBIDDEN');
        });
    }

}
