<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Artisan;

class AdminTest extends DuskTestCase
{
    /**
     * Indicates whether the database has been migrated and seeded.
     *
     * @var bool
     */

    /**
     * test
     */
    public function test_admin_login(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Inloggen')
                ->type('email', 'ppj.wilting@avans.nl')
                ->press('@login_button')
                ->screenshot('admin_show_password')
                ->AssertSee('Wachtwoord')
                ->type('password', 'password')
                ->press('@login_button')
                ->assertSee('Admin dashboard')
                ->screenshot('admin_home_page');
        });
    }

    /**
     * test
     */
    public function test_admin_create_product(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Producten')
                ->assertPathIs('/products/overview')
                ->assertSee('Producten')
                ->screenshot('admin_product_overview')
                ->clickLink('Aanmaken')
                ->assertPathIs('/products/createProduct')
                ->assertSee('Product aanmaken')
                ->screenshot('admin_create_product')
                ->waitFor('.select2-search__field')
                ->type('.select2-search__field', 'Test category')
                ->keys('.select2-search__field', '{enter}')
                ->type('name', 'Test product')
                ->type('product_code', '6786')
                ->type('stock', '20')

                //archive and secure a product
                ->check('is_secured')
                ->check('archived')
                ->type('link', 'https://www.youtube.com/watch?v=32aYALi-1xY')
                ->press('Voeg toe')
                ->screenshot('admin_create_product_filled_data_in')
                ->scrollTo('@Aanmaken')
                ->waitFor('@Aanmaken')
                ->press('@Aanmaken');

            $browser->visit('/products/details/21')
                ->screenshot('admin_new_product_added_details_page');
        });
    }

    /**
     * test
     */
    public function test_admin_edit_product(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products/details/21')
                ->clickLink('Bewerken')
                ->assertSee('Product aanpassen')
                ->screenshot('admin_edit_product')
                ->type('name', 'Test product edit name')
                ->type('product_code', '6789')
                ->type('stock', '25')
                ->uncheck('is_secured')
                ->uncheck('archived')
                ->screenshot('admin_edit_product_filled_data_in')
                ->scrollTo('@Opslaan')
                ->waitFor('@Opslaan')
                ->press('@Opslaan')
                ->assertPathIs('/products/details/21')
                ->screenshot('admin_edit_product_saved_details_page');

            //edited product, the product is now dearchived and not secured

            $browser->visit('/products/details/21')
                ->clickLink('Bewerken')
                ->assertSee('Product aanpassen')
                ->scrollTo('#deleteDropdown')
                ->waitFor('#deleteDropdown')
                ->click('#deleteDropdown')

                ->screenshot('admin_edit_product_dropdown_menu')
                ->scrollTo('.dropdown-menu.show')
                ->waitFor('.dropdown-menu.show')
                ->click('@delete-button')
                ->visit('/products/details/21')
                ->screenshot('admin_edit_product_deleted');


            //delete the test product
        });
    }

    /**
     * test
     */
    public function test_admin_loaners(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Leners')
                ->assertPathIs('/loaners/overview')
                ->assertSee('Leners')
                ->assertSee('Naam')
                ->assertSee('Email')
                ->assertSee('Momenteel geleend')
                ->assertSee('Te laat ingeleverd')
                ->assertSee('Details')
                ->screenshot('admin_loaners_overview');

            $browser->visit('/loaners/details/1')
                ->assertSee('Fenna Bos')
                ->assertSee('Email')
                ->assertSee('f.bos@student.avans.nl')
                ->screenshot('admin_loaner_detail_fenna_bos')
                ->assertSee('Geleende Producten')
                ->assertSee('Ingeleverd')
                ->assertSee('Totaal: 10')
                ->click('#dropdown-icon')
                ->assertSee('Individuele leningen:')
                ->assertSee('Van:')
                ->assertSee('Tot:')
                ->screenshot('admin_loaner_product_dropdown')
                ->Press('Ingeleverd')
                ->screenshot('admin_loaner_products_handed_in')
                ->Press('Nog in te leveren')
                ->clickLink('Neo Pixel')
                ->assertPathIs('/products/details/1')
                ->assertSee('Neo Pixel');
        });
    }

    /**
     * test
     */
    public function test_admin_loaning_for_loaners(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/loaners/2')
                ->assertSee('Producten lenen voor')
                ->clickLink('Lening opstellen')
                ->click('@add-to-cart-button')
                ->screenshot('admin_loaning_for_loaner_see_product_overview')
                ->waitFor('@lening-bevestigen')
                ->screenshot('admin_loaning_for_loaner')
                ->script("document.querySelector('a[dusk=\"lening-bevestigen\"]').click();");
            $browser->pause(1000)
                ->assertSee('De lener dient de producten terug te brengen voor')
                ->screenshot('admin_loaned_product');
            $browser->click('@lening-verzenden')
                ->pause(1000)
                ->screenshot('admin_after_loaning_for_loaner');
        });
    }

    /**
     * test
     */
    public function test_admin_handin_for_loaners(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/loaners/handin/2')
                ->assertSee('Product(en) inleveren voor')
                ->click('@verhoog-hoeveelheid')
                ->screenshot('admin_handin_for_loaner_see_product_overview')
                ->click('@open-comentaar-veld')
                ->screenshot('admin-opened-comment-field')
                ->click('@bevestig-inlevering');
        });
    }

    /**
     * test
     */
    public function test_admin_create_loaner(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/loaners/overview')
                ->assertSee('Leners')
                ->clickLink('Aanmaken')
                ->assertPathIs('/loaners/create')
                ->assertSee('Lener aanmaken')
                ->screenshot('admin_create_loaner')
                ->type('name', 'Test loaner')
                ->type('email', 'test.loaner@student.avans.nl')
                ->screenshot('admin_create_loaner_filled_data_in')
                ->press('Aanmaken');

            $browser->visit('/loaners/details/79')
                ->screenshot('admin_new_loaner_added_details_page');
        });
    }


    /**
     * test
     */
    public function test_admin_overview_category(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Categorieën')
                ->assertPathIs('/categories/overview')
                ->assertSee('Zoeken')
                ->assertSee('Details')
                ->assertSee('Vorige')
                ->assertSee('Volgende')
                ->screenshot('admin_category_overview');
        });
    }

    /**
     * test
     */
    public function test_admin_create_category(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/categories/overview')
                ->clickLink('Aanmaken')
                ->assertPathIs('/categories/createCategory')
                ->screenshot('admin_category_create')
                ->type('name', 'Test category')
                ->type('description', 'Test category description')
                ->screenshot('admin_category_create_data_filled_in')
                ->press('Aanmaken');

            $browser->visit('/categories/details/5')
                ->assertSee('Test category')
                ->screenshot('admin_category_details')
                ->assertSee('Producten');
        });
    }

    /**
     * test
     */
    public function test_admin_edit_category(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/categories/details/5')
                ->clickLink('Bewerken')
                ->assertSee('Categorie aanpassen')
                ->screenshot('admin_category_edit')
                ->type('name', 'Test category edit')
                ->type('description', 'Test category description edit')
                ->screenshot('admin_category_edit_filled_new_data_in')
                ->press('Opslaan')
                ->assertPathIs('/categories/details/5')
                ->assertSee('Test category edit')
                ->assertSee('Test category description edit')
                ->screenshot('admin_category_edit_saved_data_in')

                //edited category

                ->clickLink('Bewerken')
                ->assertSee('Categorie aanpassen')
                ->press('Annuleren')
                ->assertPathIs('/categories/details/5')
                //used cancel button

                ->clickLink('Bewerken')
                ->assertSee('Categorie aanpassen')

                ->click('#deleteDropdown')

                ->waitFor('.dropdown-menu.show')
                ->click('@delete-button')
                ->screenshot('pop_up_delete_category');
            //delete category
        });
    }

    /**
     * test
     */
    public function test_admin_due_dates(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/duedates/overview')
                ->assertSee('Eindtermijnen')
                ->clickLink('Eindtermijnen')
                ->click('#datetimepicker_button')
                ->pause(1000)
                ->script('document.querySelector("#datetimepicker").value = "01-01-2030 16:00";');

            $browser->pause(1000)
                ->script('document.querySelector("#datetimepicker")');
        });
    }

    /**
     * test
     */
    public function test_responsive_screenshots(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Admin dashboard');
            $pages = [
                '/' => 'homepage',
                '/products/overview' => 'products_overview',
                '/products/details/1' => 'product_detail',
                '//products/createProduct' => 'product_create',
                '/loaners/overview' => 'loaners_overview',
                '/loaners/details/1' => 'loaner_detail',
                '/loaners/handin/1' => 'loaner_handin',
                '/loaners/2' => 'loaner_loaning',
                '/categories/overview' => 'categories_overview',
                '/categories/createCategory' => 'categorie_create',
                '/categories/details/2' => 'categorie_detail',
                '/duedates/overview' => 'due_dates_overview',
            ];

            $screenSizes = [
                'mobile' => [375, 812],
                'tablet' => [768, 1024],
                'desktop' => [1280, 800],
            ];

            foreach ($pages as $url => $pageName) {
                foreach ($screenSizes as $sizeName => $dimensions) {
                    list($width, $height) = $dimensions;

                    $browser->visit($url)
                        ->resize($width, $height)
                        ->screenshot("responsivess_admin_{$pageName}_{$sizeName}");
                }
            }
        });
    }

}
