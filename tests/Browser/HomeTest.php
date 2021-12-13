<?php

namespace Tests\Browser;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    use DatabaseMigrations;

    // Test le code 200 de la page d'accueil
    public function test_home_status()
    {
        $this->get('/')->assertStatus(200);
    }

    //Teste que les éléments de connexion sont présents dans l'HTML

    public function test_home_form_shown()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee("Connection on Maraîcher-ESI")
                ->assertInputPresent('name')
                //DEUX FOIS : LOGIN et REGISTER
                ->assertInputPresent('email')
                //DEUX FOIS : LOGIN et REGISTER
                ->assertInputPresent('password')
                ->assertInputPresent('password_confirmation')
                ->assertPresent('button.btn-submit')
                ->assertPresent('#button_not_account')
                ->assertPresent('#button_already_account')
                //->assertInputPresent('remember')
                //Écran par défaut : boutons présents LOGIN et Not Account ?
                ->assertSee("Login")
                ->assertSee("Not account ?")
                // ->assertSee("Remember me")
                ->assertDontSee("Register")
                ->assertDontSee("Already account ?");
            //Après clic sur Not account?, les boutons deviennent Register et Already account ?
            $browser->click('#button_not_account')
                ->assertSee('Register on Maraîcher-ESI')
                ->assertDontSee("Login")
                ->assertDontSee("Not account ?")
                ->assertSee("Register")
                ->assertSee("Already account ?");
        });
    }


    public
    function test_incorrect_user_details()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email', "test@test.com")
                ->type('password', 'incorrectPass')
                ->press('Login')
                //Si l'utilisateur est faux, retourne à la page d'accueil avec un message d'erreur
                ->assertPathIs('/')
                ->assertPresent("div.alert.error")
                ->assertSee('These credentials do not match our records.');
        });
    }

    public function test_existing_email_cannot_be_taken()
    {
        $this->artisan("migrate:fresh");
        $user = User::factory()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/');
            $browser->click('#button_not_account')
                ->type('name', $user->name)
                ->type('#registerEmail', $user->email)
                //PASS is encrypted anyway
                ->type('#registerPassword', "123456789")
                ->type('password_confirmation', "123456789")
                ->press('Register')
                //Should go back to the register page with an error
                ->assertPathIs('/')
                ->assertPresent("div.alert.error")
                ->assertSee('The email has already been taken.');
        });
    }

    public function test_password_confirmation_not_matching()
    {
        $this->artisan("migrate:fresh");
        $this->browse(function (Browser $browser) {
            $browser->visit('/');
            $browser->click('#button_not_account')
                ->type('name', "Test name")
                ->type('#registerEmail', 'email@test.com')
                ->type('#registerPassword', '123456789')
                ->type('password_confirmation', "0123456789")
                ->press('Register')
                //Should go back to the register page with an error
                ->assertPathIs('/')
                ->assertPresent("div.alert.error")
                ->assertSee('The password confirmation does not match');
        });
    }

    public function test_correct_user()
    {
        $this->artisan("migrate:fresh --seed");
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email', "admin@admin.com")
                ->type("password", "adminpassword")
                ->press("Login")
                //If user is correct, the page should redirect to the /offers page, and
                //the listing of offers should be present
                ->assertPathIs('/offers')
                ->assertSee("Listing all offers of Maraîcher-ESI");
        });
    }

    public function test_correct_new_registration()
    {
        $this->artisan("migrate:fresh --seed");
        $newUser = User::factory()->make();
        $newUser->password = "password";
        $this->browse(function (Browser $browser) use ($newUser) {
            $path = parse_url($browser->driver->getCurrentURL())['path'];
            $browser->visit('/');
            if (\Str::endsWith($path, '/offers')) {
                $browser->click("#logOut");
            }
            $browser->visit('/');
            $browser->click('#button_not_account')
                ->type('name', $newUser->name)
                ->type("#registerEmail", $newUser->email)
                ->type("#registerPassword", $newUser->password)
                ->type("password_confirmation", $newUser->password)
                ->press("Register")
                //If user is correct, the page should redirect to the /offers page, and
                //the listing of offers should be present
                ->assertPathIs('/offers')
                ->assertSee("Listing all offers of Maraîcher-ESI");
        });
        $this->assertDatabaseHas('users', [
            'name' => $newUser->name,
            'email' => $newUser->email
        ]);
    }


}
