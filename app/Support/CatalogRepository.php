<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class CatalogRepository
{
    /** @return Collection<int, array{slug: string, name: string, models: list<string>, min_price: int, body: string, power: string, stock: int}> */
    public function brands(): Collection
    {
        return collect(require base_path('data/catalog.php'))->get('brands');
    }

    /** @return Collection<int, array{slug: string, name: string, where: string, region: string}> */
    public function cities(): Collection
    {
        return collect(require base_path('data/catalog.php'))->get('cities');
    }

    /** @return array{site_name: string, phone: string, email: string} */
    public function contacts(): array
    {
        $catalog = require base_path('data/catalog.php');

        return [
            'site_name' => $catalog['site_name'],
            'phone' => $catalog['phone'],
            'email' => $catalog['email'],
        ];
    }

    /** @return array{slug: string, name: string, models: list<string>, min_price: int, body: string, power: string, stock: int} */
    public function brand(string $slug): array
    {
        return $this->brands()->firstWhere('slug', $slug) ?? throw new NotFoundHttpException;
    }

    /** @return array{slug: string, name: string, where: string, region: string} */
    public function city(string $slug): array
    {
        return $this->cities()->firstWhere('slug', $slug) ?? throw new NotFoundHttpException;
    }

    /** @return Collection<int, array{url: string, label: string, brand: array, city: array}> */
    public function landingLinks(): Collection
    {
        return $this->brands()->flatMap(fn (array $brand) => $this->cities()->map(fn (array $city) => [
            'url' => route('landings.show', ['brand' => $brand['slug'], 'city' => $city['slug']], false),
            'label' => "{$brand['name']} в {$city['name']}",
            'brand' => $brand,
            'city' => $city,
        ]))->values();
    }
}
