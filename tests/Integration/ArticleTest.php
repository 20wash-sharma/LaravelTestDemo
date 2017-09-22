<?php

namespace Tests\Integration;

use Tests\TestCase;

use App\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
class ArticleTest extends TestCase
{
    use DatabaseTransactions;
    
    
   /** @test */
   function it_fetches_trending_articles()
    {
       //Given
       factory(Article::class,2)->create();
       
       factory(Article::class)->create(['reads'=>10]);
       
       $mostpopular=factory(Article::class)->create(['reads'=>20]);
       //when
       
       $articles = Article::trending()->get();
       
       //Then
       $this->assertEquals($mostpopular->id, $articles->first()->id);
       $this->assertCount(3, $articles);   
    }
    
   
}
