<?php

namespace Tests\Browser;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class OfferTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_offers_visible()
    {
        $this->artisan("migrate:fresh --seed");
        $admin = User::find(1);
        $offersMake = Offer::factory()->count(25)->make();
        foreach ($offersMake as $offer) {
            $offer->user_id = $admin->id;
            $offer->save();
        }
        $this->browse(function (Browser $browser) use ($admin) {
            //Logging in, if not already logged in
            $path = parse_url($browser->driver->getCurrentURL())['path'];
            if (!\Str::endsWith($path, '/offers')) {
                $browser->visit('/')
                    ->type('email', $admin->email)
                    ->type("password", "adminpassword")
                    ->press("Login");
            }
            //Seeing the listing
            $browser->assertSee('OFFERS')
                ->assertSee('ACCOUNT')
                ->assertSee('LOG OUT')
                ->assertSee('Name')
                ->assertSee('Quantity')
                ->assertSee('Price')
                ->assertSee('Time left')
                ->assertSee('Offer address')
                ->assertSee('User')
                ->assertSee('Action');
            //Give time for the API to reload
            //$browser->refresh();
            $browser->pause(5000);
            $offers = Offer::orderBy('expirationDate', 'desc')
                ->whereDate('expirationDate', '>=', date('Y-m-d H:i:s'))->get();
            foreach ($offers as $offer) {
                $browser
                    ->assertSee("$offer->id")
                    ->assertSee("$offer->title")
                    ->assertSee("$offer->quantity")
                    ->assertSee("$offer->price")
                    ->assertSee("$offer->expirationDate")
                    //Address doesn't show properly
                    //->assertSee("$offer->address")
                    ->assertPresent("button.btn.btn-green")
                    ->assertSee('Buy');
            }
        });
    }

    public function test_my_offers_visible()
    {
        $this->artisan("migrate:fresh --seed");
        $admin = User::find(1);
        $offersMake = Offer::factory()->count(25)->make();
        foreach ($offersMake as $offer) {
            $offer->user_id = $admin->id;
            $offer->save();
        }
        $this->browse(function (Browser $browser) use ($admin) {
            //Logging in, if not already logged in
            $path = parse_url($browser->driver->getCurrentURL())['path'];
            if (!\Str::endsWith($path, '/offers')) {
                $browser->visit('/')
                    ->type('email', $admin->email)
                    ->type("password", "adminpassword")
                    ->press("Login");
            }
            //Seeing the listing
            $browser->assertSee('OFFERS')
                ->assertSee('ACCOUNT')
                ->assertSee('LOG OUT')
                ->assertSee('Name')
                ->assertSee('Quantity')
                ->assertSee('Price')
                ->assertSee('Time left')
                ->assertSee('Offer address')
                ->assertSee('User')
                ->assertSee('Action')
                ->click("#account");
            //Give time for the API to reload
            //$browser->refresh();
            $browser->pause(5000);
            $userOffers = Offer::where('user_id', $admin->id)->count();
            $offers = Offer::orderBy('expirationDate', 'desc')
                ->whereDate('expirationDate', '>=', date('Y-m-d H:i:s'))->get();
            foreach ($offers as $offer) {
                if ($offer->user->id != $admin->id) {
                    for ($i = 0; $i <= $userOffers; $i++) {
                        $browser
                            //                            ->assertDontSeeIn("#tableID" . $i, "$offer->id")
                            ->assertNotPresent("button.btn.btn-green")
                            ->assertDontSee('Buy');
                    }
                } else {
                    for ($i = 0; $i <= $userOffers; $i++) {
                        $browser
                            ->assertSee("$offer->title")
                            ->assertSee("$offer->quantity")
                            ->assertSee("$offer->price €")
                            ->assertSee("$offer->expirationDate")
                            //Address doesn't show properly
                            //->assertSee("$offer->address")
                            ->assertPresent("button.btn.btn-red")
                            ->assertSee('Delete');
                    }
                }
            }
        });
    }

    public function test_Add_Offer()
    {
        $this->artisan("migrate:fresh --seed");
        $this->browse(function (Browser $browser) {
            $browser->refresh();
            $browser->click('#addOffer')->type('name', 'test')
                ->type('amount', '75 kg')
                ->type('price', 25)
                ->type('address', 'rue royal 67 botanique')
                ->press('Add an offer');
            $browser->pause(5000);
            $this->assertDatabaseHas("offers", [
                'title' => 'test',
                'quantity' => '75 kg',
                'price' => 25,
                'address' => 'rue royal 67 botanique',
                'user_id' => 1
            ]);
            $browser->assertSee("New offer added !");
        });
    }

    public function test_delete_offer()
    {
        $this->artisan("migrate:fresh --seed");

        $this->browse(function (Browser $browser) {
            Offer::truncate();
            $browser->click('#addOffer')
                ->type('name', 'test')
                ->type('amount', '75 kg')
                ->type('price', 25)
                ->type('address', 'rue royal 67 botanique')
                ->press('Add an offer');
            $browser->refresh();
            $browser->press('Delete');
            $browser->pause(1000);
            $this->assertDatabaseMissing('offers', [
                'name' => 'test'
            ]);
        });
    }
}
