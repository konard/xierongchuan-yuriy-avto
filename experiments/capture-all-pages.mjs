import { mkdir, writeFile } from 'node:fs/promises';
import { chromium } from 'playwright';
import catalog from '../data/catalog-preview.mjs';

const baseUrl = process.env.PREVIEW_URL ?? 'http://127.0.0.1:4174';
const outputDir = new URL('../docs/screenshots/all-pages/', import.meta.url);

const pages = [
  { path: '/', name: 'home' },
  ...catalog.brands.map((brand) => ({ path: `/cars/${brand.slug}`, name: `brand-${brand.slug}` })),
  ...catalog.cities.map((city) => ({ path: `/cities/${city.slug}`, name: `city-${city.slug}` })),
  ...catalog.brands.flatMap((brand) => catalog.cities.map((city) => ({
    path: `/cars/${brand.slug}/${city.slug}`,
    name: `landing-${brand.slug}-${city.slug}`,
  }))),
];

await mkdir(outputDir, { recursive: true });

const browser = await chromium.launch();
const page = await browser.newPage({ viewport: { width: 1440, height: 1100 }, deviceScaleFactor: 1 });
const manifest = [];

for (const item of pages) {
  const response = await page.goto(`${baseUrl}${item.path}`, { waitUntil: 'networkidle' });
  if (!response?.ok()) {
    throw new Error(`${item.path} returned ${response?.status()}`);
  }
  const fileName = `${item.name}.png`;
  await page.screenshot({ path: new URL(fileName, outputDir).pathname, fullPage: true });
  manifest.push({ ...item, screenshot: `docs/screenshots/all-pages/${fileName}` });
}

await browser.close();
await writeFile(new URL('manifest.json', outputDir), `${JSON.stringify(manifest, null, 2)}\n`);
console.log(`Captured ${manifest.length} pages into docs/screenshots/all-pages`);
