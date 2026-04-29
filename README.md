# Yuriy Avto

Laravel 13 SEO catalog for automotive landing pages by brand and city. The project targets PHP 8.5, PostgreSQL, React through Vite, Laravel Pint, and feature tests for SEO routes.

## Local setup

```bash
composer install
npm ci
cp .env.example .env
php artisan key:generate
npm run build
composer test
```

To capture the visual review set, start the static preview in one terminal and run the screenshot command in another:

```bash
npm run preview:static
npm run screenshots
```

Screenshots are written to `docs/screenshots/all-pages/` with a `manifest.json` listing every captured route.

For Podman, set `DB_PASSWORD` in `.env` before starting services:

```bash
podman compose up
```

## Implemented pages

- `/` catalog home with brand, city, and offer sections.
- `/cars/{brand}` brand index pages.
- `/cities/{city}` city index pages.
- `/cars/{brand}/{city}` SEO landing pages.
- `/sitemap.xml` and `/robots.txt`.
