<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CartItemControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    private $fakeUser;
    protected function setup(): void
    {
        parent::setUp();
        $this->fakeUser = User::create([
            'name' => 'john',
            'email' => 'john@gmail.com',
            'password' => 12345678
        ]);
        Passport::actingAs($this->fakeUser);
    }
    public function testStore()
    {
        $cart = Cart::factory()->create([
            'user_id' => $this->fakeUser->id
        ]);
        $product = Product::factory()->create();
        $response = $this->call(
            'POST',
            'cart-items',
            ['cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2]
        );
        $response->assertOk();
        $product = Product::factory()->less()->create();
        $response = $this->call(
            'POST',
            'cart-items',
            ['cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 10]
        );
        $this->assertEquals($product->title.'數量不足', $response->getContent());
        $response = $this->call(
            'POST',
            'cart-items',
            ['cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 9999]
        );
        $response->assertStatus(400);
    }
    public function testUpdate()
    {
        $cartItem = CartItem::factory()->create();
        $response = $this->call(
            'PUT',
            'cart-items/'.$cartItem->id,
            ['quantity' => 2]
        );
        $this->assertEquals('true', $response->getContent());
        $cartItem->refresh();
        $this->assertEquals(2, $cartItem->quantity);
    }
    public function testDelete()
    {
        $cart = $this->fakeUser->carts()->create();
        $product = Product::create([
            'title' => 'test Product',
            'content' => 'cool',
            'price' => 10,
            'quantity' => 10
        ]);
        $cartItem = $cart->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => 10
        ]);
        $response = $this->call(
            'DELETE',
            'cart-items/'.$cartItem->id
        );
        $response->assertOk();
        $cartItem = CartItem::find($cartItem->id);
        $this->assertNull($cartItem);
    }
}
