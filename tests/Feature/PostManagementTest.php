<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_post_can_be_created ()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/posts', [
            'title' => 'Test Title',
            'content' => 'Test Content'
        ]);

        $response->assertOk();
        $this->assertCount(1, Post::all());

        $post = Post::first();
        $this->assertEquals($post->title, 'Test Title');
        $this->assertEquals($post->content, 'Test Content');
    }

    /** @test */
    public function list_of_post_can_be_retrieved()
    {
        $this->withoutExceptionHandling();

        Post::factory()->count(3)->create();

        $response = $this->get('/posts');
        $response->assertOk();

        $posts = Post::all();
        $response->assertViewIs('posts.index');
        $response->assertViewHas('posts', $posts);
    }
}
