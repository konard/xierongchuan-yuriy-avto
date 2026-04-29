<?php

namespace Tests\Unit;

use App\Support\CatalogRepository;
use PHPUnit\Framework\TestCase;

final class CatalogRepositoryTest extends TestCase
{
    public function test_repository_builds_brand_city_landing_links(): void
    {
        $repository = new CatalogRepository;

        $this->assertCount(36, $repository->landingLinks());
        $this->assertSame('http://localhost/cars/geely/moskva', $repository->landingLinks()->first()['url']);
    }
}
