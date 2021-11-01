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

    /** @test */
    public function a_post_can_be_retrieved()
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();

        $response = $this->get('/posts/' . $post->id);
        $response->assertOk();

        $post = Post::first();
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
    }

    /** @test */
    public function a_post_can_be_created ()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/posts', [
            'title' => 'Test Title',
            'content' => 'Test Content'
        ]);

        $this->assertCount(1, Post::all());

        $post = Post::first();
        $this->assertEquals($post->title, 'Test Title');
        $this->assertEquals($post->content, 'Test Content');

        $response->assertRedirect('/posts/' . $post->id);
    }

    /** @test */
    public function a_post_can_be_updated ()
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();

        $response = $this->put('/posts/' .$post->id , [
            'title' => 'Test Title',
            'content' => 'Test Content'
        ]);

        $this->assertCount(1, Post::all());

        $post = $post->fresh();
        $this->assertEquals($post->title, 'Test Title');
        $this->assertEquals($post->content, 'Test Content');

        $response->assertRedirect('/posts/' . $post->id);
    }
}
