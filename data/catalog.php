<?php

return [
    'site_name' => 'Yuriy Avto',
    'phone' => '8 (800) 555-14-88',
    'email' => 'sales@yuriy-avto.example',
    'brands' => [
        ['slug' => 'geely', 'name' => 'Geely', 'models' => ['Monjaro', 'Coolray', 'Atlas'], 'min_price' => 2190000],
        ['slug' => 'haval', 'name' => 'Haval', 'models' => ['Jolion', 'F7', 'Dargo'], 'min_price' => 2049000],
        ['slug' => 'chery', 'name' => 'Chery', 'models' => ['Tiggo 4', 'Tiggo 7 Pro', 'Tiggo 8 Pro'], 'min_price' => 1890000],
        ['slug' => 'lada', 'name' => 'LADA', 'models' => ['Vesta', 'Granta', 'Niva Travel'], 'min_price' => 799000],
        ['slug' => 'omoda', 'name' => 'OMODA', 'models' => ['C5', 'S5', 'C7'], 'min_price' => 2399000],
        ['slug' => 'tank', 'name' => 'Tank', 'models' => ['300', '500', '700'], 'min_price' => 3899000],
    ],
    'cities' => [
        ['slug' => 'moskva', 'name' => 'Москва', 'where' => 'Москве', 'region' => 'Московская область'],
        ['slug' => 'spb', 'name' => 'Санкт-Петербург', 'where' => 'Санкт-Петербурге', 'region' => 'Ленинградская область'],
        ['slug' => 'kazan', 'name' => 'Казань', 'where' => 'Казани', 'region' => 'Татарстан'],
        ['slug' => 'ekaterinburg', 'name' => 'Екатеринбург', 'where' => 'Екатеринбурге', 'region' => 'Свердловская область'],
        ['slug' => 'novosibirsk', 'name' => 'Новосибирск', 'where' => 'Новосибирске', 'region' => 'Новосибирская область'],
        ['slug' => 'krasnodar', 'name' => 'Краснодар', 'where' => 'Краснодаре', 'region' => 'Краснодарский край'],
    ],
];
