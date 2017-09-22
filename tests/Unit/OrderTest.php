<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Product;
use App\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @test
     */
    public function an_order_consists_of_products()
    {
        $order= $this->createOrderWithProducts();
       
        
        //$this->assertEquals(2,count($order->products()));
        $this->assertCount(2,$order->products());
    }
    
    /** @test */
    function an_order_can_determine_the_total_cost_of_all_its_products(){
         $order  = $this->createOrderWithProducts();
       
        
        $this->assertEquals(57,$order->total());
        
    }
    protected function  createOrderWithProducts() {
         $order  = new Order;
        $product= new Product('Fallout 4', 50);
        $product2 = new Product('Pillowcase',7);
        $order->add($product);
        $order->add($product2);
        return $order;
    }
}
