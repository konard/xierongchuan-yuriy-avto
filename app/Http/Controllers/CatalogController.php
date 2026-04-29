<?php

namespace App\Http\Controllers;

use App\Support\CatalogRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

final readonly class CatalogController
{
    public function __construct(private CatalogRepository $catalog) {}

    public function home(): View
    {
        return view('catalog.home', $this->shared([
            'brands' => $this->catalog->brands(),
            'cities' => $this->catalog->cities(),
            'landingLinks' => $this->catalog->landingLinks(),
            'metaTitle' => 'Новые автомобили в наличии: цены, дилеры, кредит | Yuriy Avto',
            'metaDescription' => 'Каталог новых автомобилей по маркам и городам: цены, дилеры, кредит, trade-in и заявки на подбор.',
            'canonical' => route('home', [], false),
        ]));
    }

    public function brand(string $brand): View
    {
        $brandData = $this->catalog->brand($brand);

        return view('catalog.index', $this->shared([
            'title' => "{$brandData['name']}: новые автомобили по городам",
            'links' => $this->catalog->cities()->map(fn (array $city) => [
                'url' => route('landings.show', ['brand' => $brandData['slug'], 'city' => $city['slug']], false),
                'label' => "{$brandData['name']} в {$city['name']}",
            ]),
            'metaTitle' => "{$brandData['name']}: новые автомобили по городам",
            'metaDescription' => "{$brandData['name']} по городам: цены, дилеры, кредит и подбор комплектаций.",
            'canonical' => route('brands.show', ['brand' => $brandData['slug']], false),
        ]));
    }

    public function city(string $city): View
    {
        $cityData = $this->catalog->city($city);

        return view('catalog.index', $this->shared([
            'title' => "Новые автомобили в {$cityData['name']} по маркам",
            'links' => $this->catalog->brands()->map(fn (array $brand) => [
                'url' => route('landings.show', ['brand' => $brand['slug'], 'city' => $cityData['slug']], false),
                'label' => "{$brand['name']} в {$cityData['name']}",
            ]),
            'metaTitle' => "Новые автомобили в {$cityData['name']} по маркам",
            'metaDescription' => "Новые автомобили в {$cityData['name']}: цены, дилеры, кредит и подбор комплектаций.",
            'canonical' => route('cities.show', ['city' => $cityData['slug']], false),
        ]));
    }

    public function landing(string $brand, string $city): View
    {
        $brandData = $this->catalog->brand($brand);
        $cityData = $this->catalog->city($city);
        $description = "Новые автомобили {$brandData['name']} в {$cityData['where']}: модели ".implode(', ', $brandData['models']).', цены от '.$this->money($brandData['min_price']).' ₽, кредит и trade-in.';

        return view('catalog.landing', $this->shared([
            'brand' => $brandData,
            'city' => $cityData,
            'description' => $description,
            'metaTitle' => "Купить {$brandData['name']} в {$cityData['where']}: цены на новые авто у дилеров",
            'metaDescription' => $description,
            'canonical' => route('landings.show', ['brand' => $brandData['slug'], 'city' => $cityData['slug']], false),
        ]));
    }

    public function sitemap(): Response
    {
        $urls = collect([route('home', [], false)])
            ->merge($this->catalog->brands()->map(fn (array $brand) => route('brands.show', ['brand' => $brand['slug']], false)))
            ->merge($this->catalog->cities()->map(fn (array $city) => route('cities.show', ['city' => $city['slug']], false)))
            ->merge($this->catalog->landingLinks()->pluck('url'));

        return response()
            ->view('catalog.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }

    /** @param  array<string, mixed>  $data */
    private function shared(array $data): array
    {
        return [
            ...$data,
            'contacts' => $this->catalog->contacts(),
        ];
    }

    private function money(int $value): string
    {
        return number_format($value, 0, ',', ' ');
    }
}
