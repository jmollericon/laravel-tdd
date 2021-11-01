<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
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
}
