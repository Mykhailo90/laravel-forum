<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{
    /**
     * @test
     */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');

        $this->post('replies/'.$reply->id.'/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    /**
     * @test
     */
    public function guest_can_not_favorite_anything()
    {
        $reply = create('App\Reply');

        $this->withExceptionHandling()
                                ->post('replies/'.$reply->id.'/favorites')
                                ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create('App\Reply');

        try{
            $this->post('replies/'.$reply->id.'/favorites');
            $this->post('replies/'.$reply->id.'/favorites');
        } catch (\Exception $exception)
        {
            $this->fail('Did not expect to insert the same record set twice.');
        }


        $this->assertCount(1, $reply->favorites);
    }
}
