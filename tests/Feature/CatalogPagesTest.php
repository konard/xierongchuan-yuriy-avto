<?php

namespace Tests\Feature;

use Tests\TestCase;

final class CatalogPagesTest extends TestCase
{
    public function test_brand_city_landing_page_has_seo_metadata(): void
    {
        $this->get('/cars/geely/moskva')
            ->assertOk()
            ->assertSee('<title>Купить Geely в Москве: цены на новые авто у дилеров</title>', false)
            ->assertSee('<meta name="description"', false)
            ->assertSee('<h1>Купить Geely в Москве</h1>', false)
            ->assertSee('<link rel="canonical" href="http://localhost/cars/geely/moskva">', false);
    }

    public function test_sitemap_contains_index_and_landing_pages(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee('/cars/geely/moskva', false)
            ->assertSee('/cities/moskva', false)
            ->assertSee('/cars/geely', false);
    }

    public function test_unknown_brand_returns_not_found(): void
    {
        $this->get('/cars/unknown/moskva')->assertNotFound();
    }
}
