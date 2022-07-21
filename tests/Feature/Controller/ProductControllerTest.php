<?php

namespace Tests\Feature;

use App\Http\Services\ShortUrlService;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    private $fakeUser;
    protected function setup(): void
    {
        parent::setUp();
    }
    public function testSharedUrl()
    {
        $product = Product::factory()->create();
        $id = $product->id;
        $this->mock(ShortUrlService::class, function($mock)use($id){
            $mock->shouldReceive('makeShorturl')
                ->with("http://localhost:8000/products/$id")
                ->andReturn('fakeUrl');
        });
        $response = $this->call(
            'GET',
            'products/'.$id.'/shared-url'
        );
        $response->assertOk();
        $response = json_decode($response->getContent(), true);
        $this->assertEquals($response['url'], 'fakeUrl');
    }
}