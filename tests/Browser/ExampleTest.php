<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\Artisan;

class ExampleTest extends DuskTestCase
{
    use DatabaseMigrations;
    protected function setup():void
    {
        parent::setUp();
        User::factory()->create([
            'email' => 'john@gmail.com'
        ]);
        Artisan::call('db:seed', ['--class' => 'ProductSeeder']);
    }
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            // '--disable-gpu',
            // '--headless'
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->with('.title' ,function($text){
                        $text->assertSee('固定資料');
                    });
            $browser->click('.check_product')
                    ->waitForDialog(5)
                    ->assertdialogOpened('商品數量充足')
                    ->acceptDialog();
            eval(\Psy\sh());
        });
    }
}
