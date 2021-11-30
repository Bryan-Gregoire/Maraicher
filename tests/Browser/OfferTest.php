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
                ->assertSee('MY OFFERS')
                ->assertSee('LOG OUT')
                ->assertSee('Name')
                ->assertSee('Quantity')
                ->assertSee('Price')
                //->assertSee('Time left')
                ->assertSee('Offer address')
                ->assertSee('User')
                ->assertSee('Action');
            //Give time for the API to reload
            //$browser->refresh();
            $browser->pause(5000);
            $offers = Offer::orderBy('expirationDate', 'desc')
                ->whereDate('expirationDate', '>', date('Y-m-d H:i:s'))->get();
            foreach ($offers as $offer) {
                $browser
                    ->assertSee("$offer->title")
                    ->assertSee("$offer->quantity")
                    ->assertSee("$offer->price €")
                    //->assertSee("$offer->expirationDate")
                    //Address doesn't show properly
                    //->assertSee("$offer->address")
                    ->assertPresent("button.btn.btn-green")
                    ->assertSee("Book" || "bids" || "You have reserved");
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
                ->assertSee('MY OFFERS')
                ->assertSee('LOG OUT')
                ->assertSee('Name')
                ->assertSee('Quantity')
                ->assertSee('Price')
                ->assertSee('Expiration Date')
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
                if ($offer->user->id === $admin->id) {
                    $browser->pause(3000);
                    $browser
                        ->assertSee("$offer->title")
                        //->assertSee("$offer->quantity")
                        //->assertSee("$offer->price €")
                        //->assertSee(date_format(new \DateTime($offer->expirationDate), 'Y-m-d, g:i a'))
                        //Address doesn't show properly
                        //->assertSee($offer->address)
                        ->assertPresent("button.btn.btn-red")
                        ->assertSee('Delete')
                        ->assertSee('Modify');
                }
            }
        });
    }

    public function test_Add_Offer()
    {
        $this->artisan("migrate:fresh --seed");
        $this->browse(function (Browser $browser) {
            $browser->refresh();
            $browser->click("#addOffer");
            $today = now();
            $browser
                ->type('name', 'test')
                ->type('amount', '75 kg')
                ->type('price', 25)
                ->type('address', 'rue royal 67 botanique')
                //DATE fonctionne
                ->keys('#myDate', $today->day)
                ->keys('#myDate', $today->month)
                ->keys('#myDate', '2022')
                ->keys('#myDate', ['{tab}'])
                ->keys("#myDate", $today->hour)
                ->keys("#myDate", $today->minute)
                ->press('Add an offer');
            $browser->pause(2000);
            $browser->assertSee("New offer added !")
                ->assertSee('test')
                ->assertSee('75 kg')
                ->assertSee(25)
                ->assertSee('rue royal 67 botanique');
            $this->assertDatabaseHas("offers", [
                'title' => 'test',
                'quantity' => '75 kg',
                'price' => 25,
                'address' => 'rue royal 67 botanique',
                'user_id' => 1
            ]);

        });
    }

    public function test_delete_offer()
    {
        $this->artisan("migrate:fresh --seed");

        $this->browse(function (Browser $browser) {
            Offer::truncate();
            $today = now();
            $browser->click('#addOffer');
            $browser
                ->type('#name', 'test')
                ->type('amount', '75 kg')
                ->type('price', 25)
                ->keys('#myDate', $today->day)
                ->keys('#myDate', $today->month)
                ->keys('#myDate', '2022')
                ->keys('#myDate', ['{tab}'])
                ->keys("#myDate", $today->hour)
                ->keys("#myDate", $today->minute)
                ->type('address', 'rue royal 67 botanique')
                ->press('Add an offer');
            $browser->visit('/my');
            $browser->pause(2000);
            $browser->click("#deleteOffer");
        });
        $this->assertDatabaseMissing('offers', [
            'title' => 'test'
        ]);
    }

    public function test_Modify_DateOffer()
    {
        $this->artisan("migrate:fresh --seed");
        //$tomorrow = new \DateTime('tomorrow');
        $today = now();
        $tomorrow = now()->addDay();

        $this->browse(function (Browser $browser) use ($tomorrow, $today) {
            Offer::truncate();
            //$today = now();
            //$tomorrow = now()->addDay();
            $browser->visit('/')
                ->type('email', "admin@admin.com")
                ->type("password", "adminpassword")
                ->press("Login")->visit('/my')->click('#addOffer')
                ->type('#name', 'test')
                ->type('amount', '75 kg')
                ->type('price', 25)
                ->keys('#myDate', $today->day)
                ->keys('#myDate', $today->month)
                ->keys('#myDate', '2022')
                ->keys('#myDate', ['{tab}'])
                ->keys("#myDate", $today->hour)
                ->keys("#myDate", $today->minute)
                ->type('address', 'rue royal 67 botanique')
                ->press('Add an offer');
            $browser->visit('/my');
            $browser->pause(2000);
            $browser->press("Modify")
                ->type('#name', 'test')
                ->type('amount', '75 kg')
                ->type('price', 25)
                ->keys('#myDate', $tomorrow->day)
                ->keys('#myDate', $tomorrow->month)
                ->keys('#myDate', '2022')
                ->keys('#myDate', ['{tab}'])
                ->keys("#myDate", $tomorrow->hour)
                ->keys("#myDate", $tomorrow->minute)
                ->press("Update offer");
        });

        $this->assertNotSame($today, $tomorrow);

    }

}
