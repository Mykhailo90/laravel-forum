<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;


    protected $thread;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
        $this->user = create('App\User');
    }
    /**
     * @test
     */
    public function an_authenticated_user_can_create_new_threads()
    {
        //Given we have a signed user

        $this->signIn();

        //When we hit the endpoint to create a new thread

        $this->post('/threads', $this->thread->toArray());

        //Then when we visit thread page

        $response = $this->get($this->thread->path());

        //We should see the new thread

        $response->assertSee($this->thread->title)
                ->assertSee($this->thread->body);
    }

    /**
     * @test
     */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

            $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

}
