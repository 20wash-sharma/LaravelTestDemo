<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Team;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
class TeamTest extends TestCase
{
        use DatabaseTransactions;

    /** @test */
    public function a_team_has_a_name()
    {
        $team= new Team(['name'=>'Acme']);
        $this->assertEquals('Acme', $team->name);
    }
    
    /** @test */
    public function a_team_can_add_members()
    {
       
        
        $team = factory(Team::class)->create();
        $user = factory(User::class)->create();
        $userTwo= factory(User::class)->create();
        $team->add($user);
        $team->add($userTwo);
        $this->assertEquals(2, $team->count());
    }
    /** @test */
    public function a_team_has_a_maximum_size()
    {
        $team= factory(Team::class)->create(['size'=>2]);
    
        $user = factory(User::class)->create();
        $userTwo= factory(User::class)->create();
        $team->add($user);
        $team->add($userTwo);
        $this->assertEquals(2, $team->count());
        
         //$this->setExpectedException('Exception');
        $this->expectException(\Exception::class);
         
        $userThree= factory(User::class)->create();
        $team->add($userThree);
        
        
       
    }
     /** @test */
    public function a_team_can_add_multiple_members_at_once()
    {
        $team= factory(Team::class)->create();
    
        $users = factory(User::class,2)->create();
        $team->add($users);
      $this->assertEquals(2, $team->count());
       
    }
    /** @test */
    public function a_team_can_remove_a_member()
    {
        $team= factory(Team::class)->create();
    
        $users = factory(User::class,2)->create();
        $team->add($users);
        $team->remove($users[0]);
      $this->assertEquals(1, $team->count());
       
    }
   
    /** @test */
    public function a_team_can_remove_all_members_at_once()
    {
        
      $team= factory(Team::class)->create();
    
        $users = factory(User::class,2)->create();
        $team->add($users);
        //Alternate one to use the same method remove
       // $team->remove();
        
        //Alternate two to write a dedicated method to remove everyone from the team i.e to make team_id null not delete the members
        $team->restart();
      $this->assertEquals(0, $team->count());
    }
    
     /** @test */
    public function a_team_can_remove_more_than_one_member_at_once()
    {
        
       $team= factory(Team::class)->create(['size'=>3]);
    
        $users = factory(User::class,3)->create();
        $team->add($users);
        
       $team->remove($users->slice(0,2));
        
       
      $this->assertEquals(1, $team->count());
    }
   
    /** @test  this is an example of regresssion test: we have written a regression test to reproduce the bug , so now we will be refactoring the add method*/
    public function when_adding_many_members_at_once_you_still_may_not_exceed_the_team_maximum_size(){
         $team= factory(Team::class)->create(['size'=>2]);
    
        $users = factory(User::class,3)->create();
       $this->expectException(\Exception::class);
        $team->add($users);
        
    }
    
}
