<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Team extends Model
{
   protected $fillable = ['name','size'];
   
   public function add($users){
       $this->guardAgainstTooManyMembers($users);
      /* if($user instanceof User){
        return $this->members()->save($user);   
       }
       $this->members()->saveMany($user);*/
       //Refactoring the above code
       $method  = $users instanceof User ? 'save' : 'saveMany';
   
       $this->members()->$method($users);
   }
    /*public function remove($user=null){
       //alternative one
        //$this->members()->where('id',$user->id)->delete();
        //alternative two, for this you have to add team_id to the fillable property in the user model for mass assignment
      // $user->update(['team_id'=>null]);
        
        if(!$user)
        {
            return $this->members()->update(['team_id'=>null]);
        }
        
        //alternative three and create a leaveTeam method inside the user model
        $user->leaveTeam();
   }*/
   
  /* public function remove(User $user){
       //alternative one
        //$this->members()->where('id',$user->id)->delete();
        //alternative two, for this you have to add team_id to the fillable property in the user model for mass assignment
      // $user->update(['team_id'=>null]);
        
      
        
        //alternative three and create a leaveTeam method inside the user model
        $user->leaveTeam();
   }*/
   
   public function remove( $users=null){
       if($users instanceof User){
           return $users->leaveTeam();
       }
      
       //Alternate one hits the database many times
      /* $users->each(function($user){
           $user->leaveTeam();
       });*/
       
       return $this->removeMany($users);
              
       
       
               
        
   }
   
   public function removeMany($users){
      $userIds = $users->pluck('id');
       return $this->members()->whereIn('id', $userIds)->update(['team_id'=>null]);
        
               
   }
   public function maximumSize(){
       return $this->size;
   }
   
   
   public function restart(){
        return $this->members()->update(['team_id'=>null]);
   }
   public function members(){
       return $this->hasMany(User::class);
   }
   public function count()
   {
       return $this->members()->count();
   }
   
   protected function guardAgainstTooManyMembers($users){
       //echo 'the object count '.$this->count().' the size: '.$this->size;
       
      // $numUsersToAdd = ($users instanceof User) ? 1 : $users->count();
       //if the $users is an array instead of a collection 
      $numUsersToAdd = ($users instanceof User) ? 1 : count($users);
      
       $newTeamCount= $this->count() + $numUsersToAdd;
       if($newTeamCount > $this->maximumSize()){
           throw new \Exception;
       }
   }
}
