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

        $this->thread = factory('App\Thread')->create();
        $this->reply = factory('App\Reply')->make();
    }

    /**
    * @test
    */
   public function a_authentificated_user_may_participate_in_forum_threads()
   {
       $this->be(factory('App\User')->create());

      $this->post($this->thread->path().'/replies', $this->reply->toArray());

      $this->get($this->thread->path())
                                ->assertSee($this->reply->body);
   }

    /**
     * @test
     */
    public function an_authentificated_user_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post($this->thread->path().'/replies', $this->reply->toArray());

    }
}
