<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase {

    protected $product;

    public function setUp() {
        $this->product = new Product('BishProduct 4', 59);
    }

    /** @test */
    public function a_product_has_a_name() {

        $this->assertEquals('BishProduct 4', $this->product->name());
    }
    /** @test */
    function a_product_has_a_cost() {

        $this->assertEquals(59, $this->product->cost());
    }

}
