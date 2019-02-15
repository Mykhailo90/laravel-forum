<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    // See TestCase
    //    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        // See utilities/functions
//        $this->thread = factory('App\Thread')->create();
        $this->thread = create('App\Thread');
    }

    /**
     * @test
     */
    public function a_user_can_browse_threads()
    {

       $this->get('/threads')
                            ->assertStatus(200)
                            ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
                            ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_read_a_single_threads()
    {
        $this->get($this->thread->path())
                            ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_read_replices_that_are_associated_with_a_thread()
    {
//        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
                            ->assertSee($reply->body);

    }
}
