import { createServer } from 'node:http';
import { readFile } from 'node:fs/promises';
import { extname, join } from 'node:path';
import catalog from '../data/catalog-preview.mjs';

const css = await readFile(new URL('../resources/css/app.css', import.meta.url), 'utf8');
const svg = await readFile(new URL('../public/images/hero-showroom.svg', import.meta.url), 'utf8');

const money = (value) => new Intl.NumberFormat('ru-RU').format(value);
const esc = (value) => String(value).replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;');

const landingLinks = catalog.brands.flatMap((brand) => catalog.cities.map((city) => ({
  url: `/cars/${brand.slug}/${city.slug}`,
  label: `${brand.name} в ${city.name}`,
  brand,
  city,
})));

function layout({ title, description, canonical, body }) {
  return `<!doctype html><html lang="ru"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>${esc(title)}</title><meta name="description" content="${esc(description)}"><link rel="canonical" href="${esc(canonical)}"><style>${css}</style></head><body><header class="topbar"><a class="brand" href="/"><span>YA</span>${catalog.site_name}</a><nav aria-label="Основная навигация"><a href="/#brands">Марки</a><a href="/#cities">Города</a><a href="/#offers">Предложения</a><a href="/sitemap.xml">Sitemap</a></nav><a class="phone" href="tel:+78005551488">${catalog.phone}</a></header>${body}<footer class="footer"><strong>${catalog.site_name}</strong><span>Новые автомобили от официальных дилеров, кредит, trade-in и подбор под бюджет.</span><a href="mailto:${catalog.email}">${catalog.email}</a></footer></body></html>`;
}

function carPlate(small = false) {
  return `<div class="car-plate${small ? ' car-plate--small' : ''}"><span class="car-plate__roof"></span><span class="car-plate__body"></span><span class="car-plate__wheel car-plate__wheel--left"></span><span class="car-plate__wheel car-plate__wheel--right"></span></div>`;
}

function home() {
  return layout({
    title: 'Новые автомобили в наличии: цены, дилеры, кредит | Yuriy Avto',
    description: 'Каталог новых автомобилей по маркам и городам: цены, дилеры, кредит, trade-in и заявки на подбор.',
    canonical: '/',
    body: `<main><section class="hero"><div class="hero__copy"><p class="eyebrow">Новые автомобили от официальных дилеров</p><h1>Подбор авто по марке, городу и реальной цене</h1><p>Коммерческие посадочные страницы для заявок на новые Geely, Haval, Chery, LADA, OMODA и Tank с локальными дилерами, кредитом и trade-in.</p><form class="search"><select>${catalog.brands.map((brand) => `<option>${brand.name}</option>`).join('')}</select><select>${catalog.cities.map((city) => `<option>${city.name}</option>`).join('')}</select><button>Показать предложения</button></form></div><div class="hero__visual">${carPlate()}<div class="hero__panel"><span>${catalog.brands.length} марок</span><span>${catalog.cities.length} городов</span><span>${landingLinks.length} SEO страниц</span></div></div></section><section id="offers" class="section"><h2>Лучшие предложения</h2><div class="cards">${catalog.brands.map((brand, index) => { const city = catalog.cities[index % catalog.cities.length]; return `<article class="card"><div class="badge">${city.name}</div><h3>${brand.name} ${brand.models[0]}</h3><p>${brand.body}, ${brand.power}. От ${money(brand.min_price)} ₽, кредит от 4,9%, trade-in и резерв у дилера.</p><div class="card__meta"><span>${brand.stock} авто</span><span>ПТС в наличии</span></div><a href="/cars/${brand.slug}/${city.slug}">Смотреть ${brand.name} в ${city.name}</a></article>`; }).join('')}</div></section><section id="brands" class="section"><h2>Марки новых авто</h2><div class="link-grid">${catalog.brands.map((brand) => `<a href="/cars/${brand.slug}">${brand.name} от ${money(brand.min_price)} ₽</a>`).join('')}</div></section><section id="cities" class="section"><h2>Города</h2><div class="link-grid">${catalog.cities.map((city) => `<a href="/cities/${city.slug}">${city.name} · ${city.region}</a>`).join('')}</div></section><section class="section"><h2>Посадочные страницы</h2><div class="landing-grid">${landingLinks.map((link) => `<a href="${link.url}">${link.label}</a>`).join('')}</div></section></main>`,
  });
}

function indexPage(title, links) {
  return layout({
    title,
    description: title,
    canonical: '/',
    body: `<main><section class="section section--first index-hero"><div><p class="eyebrow">Навигация по каталогу</p><h1>${title}</h1><p>Выберите посадочную страницу с локальным спросом, ценами, моделями и формой заявки для дилерского подбора.</p></div><div class="index-stats"><span>${links.length} направлений</span><span>Цены дилеров</span><span>Кредит и trade-in</span></div></section><section class="section"><h2>Доступные страницы</h2><div class="cards cards--links">${links.map((link) => `<article class="card"><div class="badge">SEO страница</div><h3>${link.label}</h3><p>Коммерческий экран с моделями, локальным интентом, заявкой и перелинковкой.</p><a href="${link.url}">Открыть подбор</a></article>`).join('')}</div></section></main>`,
  });
}

function landing(brand, city) {
  const description = `Новые автомобили ${brand.name} в ${city.where}: модели ${brand.models.join(', ')}, цены от ${money(brand.min_price)} ₽, кредит и trade-in.`;
  return layout({
    title: `Купить ${brand.name} в ${city.where}: цены на новые авто у дилеров`,
    description,
    canonical: `/cars/${brand.slug}/${city.slug}`,
    body: `<main><section class="hero hero--compact"><div class="hero__copy"><p class="eyebrow">${city.region}</p><span data-react-lead-status></span><h1>Купить ${brand.name} в ${city.where}</h1><p>${description}</p><a class="primary" href="#lead">Получить предложения дилеров</a></div><div class="hero__visual hero__visual--compact">${carPlate(true)}<div class="hero__panel"><span>Цена от ${money(brand.min_price)} ₽</span><span>${brand.stock} авто в подборке</span><span>Подбор за 15 минут</span></div></div></section><section class="section"><h2>Популярные модели ${brand.name}</h2><div class="cards">${brand.models.map((model, index) => `<article class="card"><div class="badge">В наличии</div><h3>${brand.name} ${model}</h3><p>от ${money(brand.min_price + index * 270000)} ₽ · ${brand.body} · ${brand.power}</p><div class="card__meta"><span>Гарантия дилера</span><span>Кредит онлайн</span></div><a href="#lead">Запросить цену</a></article>`).join('')}</div></section><section class="section two-col"><div><h2>Почему это удобно</h2><p>Страница закрывает коммерческий спрос по марке и городу: содержит точный title, description, H1, локальный интент, FAQ, перелинковку и sitemap.</p></div><form id="lead" class="lead"><input placeholder="Ваше имя"><input placeholder="Телефон"><button>Получить расчет</button></form></section><section class="section"><h2>Вопросы о ${brand.name} в ${city.where}</h2><details><summary>Какие модели доступны?</summary><p>В подборке есть ${brand.models.join(', ')} и близкие комплектации у официальных дилеров.</p></details><details><summary>Можно ли оформить кредит?</summary><p>Да, заявка передается дилерам и банкам-партнерам для расчета ежемесячного платежа.</p></details><details><summary>Как проверить цену?</summary><p>Оставьте заявку: менеджер сверит наличие, скидки, trade-in и финальную стоимость.</p></details></section></main>`,
  });
}

const server = createServer((request, response) => {
  const path = new URL(request.url, 'http://127.0.0.1').pathname;
  if (path === '/images/hero-showroom.svg') {
    response.writeHead(200, { 'Content-Type': 'image/svg+xml' });
    response.end(svg);
    return;
  }
  if (extname(path)) {
    response.writeHead(404);
    response.end('Not found');
    return;
  }
  let html = path === '/' ? home() : null;
  const brandMatch = path.match(/^\/cars\/([^/]+)$/);
  const cityMatch = path.match(/^\/cities\/([^/]+)$/);
  const landingMatch = path.match(/^\/cars\/([^/]+)\/([^/]+)$/);
  if (brandMatch) {
    const brand = catalog.brands.find((item) => item.slug === brandMatch[1]);
    html = brand && indexPage(`${brand.name}: новые автомобили по городам`, catalog.cities.map((city) => ({ url: `/cars/${brand.slug}/${city.slug}`, label: `${brand.name} в ${city.name}` })));
  }
  if (cityMatch) {
    const city = catalog.cities.find((item) => item.slug === cityMatch[1]);
    html = city && indexPage(`Новые автомобили в ${city.name} по маркам`, catalog.brands.map((brand) => ({ url: `/cars/${brand.slug}/${city.slug}`, label: `${brand.name} в ${city.name}` })));
  }
  if (landingMatch) {
    const brand = catalog.brands.find((item) => item.slug === landingMatch[1]);
    const city = catalog.cities.find((item) => item.slug === landingMatch[2]);
    html = brand && city && landing(brand, city);
  }
  response.writeHead(html ? 200 : 404, { 'Content-Type': 'text/html; charset=utf-8' });
  response.end(html || 'Not found');
});

server.listen(4174, '127.0.0.1', () => {
  console.log('Static preview: http://127.0.0.1:4174');
});
