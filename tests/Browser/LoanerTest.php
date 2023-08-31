<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoanerTest extends DuskTestCase
{
    /**
     * test
     */
    public function test_loaner_login(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email', 'f.bos@student.avans.nl')
                ->press('@login_button')
                ->screenshot('loaner_logged_in')
                ->assertSee('Welkom lener');
        });
    }

    /**
     * test
     */
    public function test_loaner_homepage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Welkom lener')
                ->assertSee('Uitgelichte producten')
                ->assertSee('Categorieën')
                ->click('@add-to-cart-button')
                ->screenshot('loaner_loaning_from_featured_products');
        });
    }

    /**
     * test
     */
    public function test_homepage_categories(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Categorieën')
                ->click('.category-card')
                ->assertSee('Product lenen')
                ->screenshot('loaner_productoverview_based_on_category');

            $products_first_category = ["Neo Pixel Stick", "Neo Pixel"];
            foreach ($products_first_category as $product) {
                $browser->assertSee($product);
            }
        });
    }

    /**
     * test
     */
    public function test_homepage_products(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->screenshot('loaner_homepage')
                ->assertSee('Uitgelichte producten')
                ->click('.product-card')
                ->screenshot('loaner_product_detail_page')
                ->assertSee('Product informatie');
        });
    }

    /**
     * test
     */
    public function test_loaning_products(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/product/1')
                ->assertSee('Neo Pixel Stick')
                ->screenshot('loaner_product_details');

            $browser->screenshot('loaner_loaning_from_details_page')
                ->click('@add-to-cart-button');
        });
    }

    /**
     * test
     */
    public function test_checkout(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('@checkout')
                ->assertPathIs('/loaning/check-out')
                ->screenshot('loaner_checkout_page')
                ->click('@lening-verzenden')
                ->assertSee('Product(en) inleveren');
        });
    }

    /**
     * test
     */
    public function test_handin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/handin')
                ->assertSee('inleveren')
                ->screenshot('loaner_handin_before_increased_amount')
                ->click('@verhoog-hoeveelheid')
                ->screenshot('loaner_handin_in_after_increased_amount')
                ->click('@open-comentaar-veld')
                ->screenshot('loaner-opened-comment-field')
                ->click('@bevestig-inlevering')
                ->screenshot('loaner_handedin_one_product');

        });
    }

    /**
     * test
     */
    public function test_loaning_status(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('@profiel')
                ->assertSee('Hallo')
                ->screenshot('loaner_profiel_page')
                ->clickLink('Bekijk hier de status van je inleveringen.')
                ->assertPathIs('/returns')
                ->assertSee('Inleveringen')
                ->screenshot('loaner_returns_page');
        });
    }

    /**
     * test
     */
    public function test_responsive_screenshots(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Welkom lener');

            $pages = [
                '/' => 'homepage',
                '/loaning' => 'loaning_overview',
                '/product/1' => 'product_detail_page',
                '/handin' => 'handin_page',
                '/loaning/check-out' => 'checkout_page',
                '/account?id=1' => 'account_page',
                '/returns' => 'returns_page',
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
                        ->screenshot("responsivess_loaner_{$pageName}_{$sizeName}");
                }
            }
        });
    }

}
