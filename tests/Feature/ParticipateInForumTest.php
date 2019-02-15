<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;
    protected $reply;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
        $this->reply = make('App\Reply');
    }

    /**
    * @test
    */
   public function a_authentificated_user_may_participate_in_forum_threads()
   {
       $this->signIn(create('App\User'));

      $this->post($this->thread->path().'/replies', $this->reply->toArray());

      $this->get($this->thread->path())
                                ->assertSee($this->reply->body);
   }

    /**
     * @test
     */
    public function an_authentificated_user_may_not_add_replies()
    {
       $this->withExceptionHandling()
           ->post($this->thread->path().'/replies', $this->reply->toArray())
           ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function a_reply_requires_a_body()
    {
       $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path().'/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
