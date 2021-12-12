<?php

namespace Tests\Browser;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReservationTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */

    public function test_Choose_Customer_Offer()
    {
        $this->artisan("migrate:fresh --seed");
        $today = now();
        $this->browse(function (Browser $browser) use ($today) {
            $browser->visit('/')
                ->type('email', "admin@admin.com")
                ->type("password", "adminpassword")
                ->press("Login")->visit('/my')->click('#addOffer')->pause(2000)
                ->type('#name', 'Vache')
                ->type('amount', '75 kg')
                ->type('price', 100)
                ->keys('#myDate', $today->day)
                ->keys('#myDate', $today->month)
                ->keys('#myDate', '2022')
                ->keys('#myDate', ['{tab}'])
                ->keys("#myDate", $today->hour)
                ->keys("#myDate", $today->minute)
                ->type('address', 'rue royal 67 botanique')
                ->press('Add an offer')
                ->click('#logOut');
            $browser->pause(2000);
            $browser->click('#button_not_account')
                ->type('name', "root")
                ->type("#registerEmail", "root@root5433.be")
                ->type("#registerPassword", "rootroot")
                ->type("password_confirmation", "rootroot")
                ->press("Register")
                ->visit('/offers')->press('Book')
                ->click('#logOut');
            $browser->visit('/');
            $browser->click('#button_not_account')
                ->type('name', "root2")
                ->type("#registerEmail", "root2@root4003.be")
                ->type("#registerPassword", "rootroot")
                ->type("password_confirmation", "rootroot")
                ->press("Register")
                ->visit('/offers')->press('Book')
                ->click('#logOut');
            $browser->pause(2000);

            $browser->visit('/')
                ->type('email', "admin@admin.com")
                ->type("password", "adminpassword")
                ->press("Login")->visit('/offers');
            $browser->pause(2000)
                ->press(".bidsClick")
                ->press("Choose this buyer !");
            $browser->assertSee('SOLD');
        });

    }
}
