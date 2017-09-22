<?php

namespace Tests\Integration;

use Tests\TestCase;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LikesTest extends TestCase
{
    use DatabaseTransactions;
    
    protected  $post;
    
    public function setUp(){
        parent::setUp();
        //$this->post= factory(Post::class)->create();
        
        $this->post=createPost();//createPost is a global function defined inside test\helpers\functions.php autoloaded in the file section of the require-dev dependencies in composer.json accessible after running the command composer dump-autoload in the command prompt.
        $this->signIn();
    }


    /** @test */
   function a_user_can_like_a_post()
    {
       //Given I have a post
      // $this->post= factory(Post::class)->create();
       // and a user
       //$user = factory(User::class)->create();
       
       //and that user is logged in 
       //$this->actingAs($user);// or $this->be($user), be is an alias
       // when they like a post
       
       $this->post->like();
       
       
       
       //then we should see evidence in the database, and the post should be liked
       $this->assertDatabaseHas('likes',[
           'user_id'=> $this->user->id,
           'likeable_id'=>$this->post->id,
           'likeable_type'=>get_class($this->post)
       ]);
       
       $this->assertTrue($this->post->isLiked());
       }
       
       /** @test */
   function a_user_can_unlike_a_post()
    {
       //Given I have a post
       //$this->post= factory(Post::class)->create();
       // and a user
      // $user = factory(User::class)->create();
       //and that user is logged in 
      // $this->actingAs($user);// or $this->be($user), be is an alias
       // when they like a post
       
       $this->post->like();
       
        $this->post->unLike();
       
       
       
       //then we should see evidence in the database, and the post should be liked
       $this->assertDatabaseMissing('likes',[
           'user_id'=> $this->user->id,
           'likeable_id'=>$this->post->id,
           'likeable_type'=>get_class($this->post)
       ]);
       
       $this->assertFalse($this->post->isLiked());
       }
       
       /** @test */
    public function a_user_may_toggle_a_posts_like_status(){
        // $this->post= factory(Post::class)->create();
       // and a user
       //$user = factory(User::class)->create();
       //and that user is logged in 
       //$this->actingAs($user);// or $this->be($user), be is an alias
       // when they like a post
       
       $this->post->toggle();
       
        $this->assertTrue($this->post->isLiked());
        $this->post->toggle();
       
       
       $this->assertFalse($this->post->isLiked());
    }
    
     /** @test */
    public function a_post_knows_how_many_likes_it_has(){
         //$this->post= factory(Post::class)->create();
       // and a user
     //  $user = factory(User::class)->create();
       //and that user is logged in 
      // $this->actingAs($user);// or $this->be($user), be is an alias
       // when they like a post
       
       $this->post->toggle();
       
        $this->assertEquals(1,$this->post->likesCount);
        $this->post->toggle();
       
       
       $this->assertFalse($this->post->isLiked());
    }
    
    
   
}
