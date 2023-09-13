<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Str;
use Tests\TestCase;

class MainTest extends TestCase
{
    public function test_promotions(): void
    {
        $response = $this->get(route('main.promotions'));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page'
            ]);
    }

    public function test_posts(): void
    {
        $response = $this->get(route('main.posts'));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page'
            ]);
    }

    public function test_post_index(): void
    {
        $response = $this->get(route('main.post.index',[Post::first()->uuid]));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);
    }
}
