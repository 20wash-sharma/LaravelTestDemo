<?php

namespace App;



class order 
{
     protected $products=[];
     
     
   
    public function add($product){
        return $this->products[]=$product;
    }
    public function products(){
       
        
        return $this->products;
    }
    public function total(){
       /* $total=0;
        foreach($this->products as $product){
            $total+= $product->cost();
        }
        return $total;*/
        
        return array_reduce($this->products, function($carry,$product){
            return $carry + $product->cost();
        });
    }
}
