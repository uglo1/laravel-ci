<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testIsLikedByNull() 
    {
        $article = factory(Article::class)->create();
        
        $result = $article->isLikedBy(null);
    
        $this->assertFalse($result);
    }

    public function testIsLikedByTheUser()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $article->likes()->attach($user);

        $result = $article->isLikedBy($user);

        $this->assertTrue($result);
    }

    public function testIsLikedByAnother()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $another = factory(User::class)->create();
        // 自分ではない他人が記事にいいねをする
        $article->likes()->attach($another);

        // $userがこの記事をいいねしているかの結果
        $result = $article->isLikedBy($user);

        $this->assertFalse($result);
    }
}
