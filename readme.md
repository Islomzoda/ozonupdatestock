# OzonUpdateStock

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require islomzoda/ozonupdatestock
```

## Usage

для коректной работы пакета в .env добавтье поля
``` 
OZON_CLIENT_ID=ид магазина
OZON_API_KEY=ключт от апи 
OZON_WH_ID=ид склада 

```

в папку **storage/app/asset/**
добавим файл **alias.xlsx**
там будеть хранить сопоставление для 1с и мост между Озон
выполняем команду
```
php artisan migrate
```
 дольжно появится таблица **ozon_match** 

потом загружаем мост
```
php artisan ozon:alias
```
в таблице дольжно появится данные поле product_id пустое так как мы не будем их загружать в ручную если все такие вы решили загрузить в ручную тогда можете проспустить следуюший шаг


загружаем сапоставление из озон 
```
php artisan ozon:match
```

Все наше библетека готова для использование

пример использованиезоватся

```
<?php

namespace App\Service\MarketPlace\Ozon;

use App\Service\Accounting\OneC\OneC;
use Illuminate\Support\Facades\DB;
use Islomzoda\OzonUpdateStock\Facades\OzonUpdateStock;

class UpdateStockOzon
{
    public function updateStock(){
    // запрашиваем остатки от учетной системы в моем слуйчай это 1с
        $items = (new OneC())->getAmountAndPrices();
        $update = [];
        foreach($items->{"ПакетПредложений"}->{"Предложения"}->{"Предложение"} as $item){
            $getItem = DB::table('ozon_match')->where('one_c_uid', $item->{"Ид"})->first();
            if ($getItem){
            // так как валидация озон будеть ругаться на минусовые значение мы сделали свою неболшую проверку  
                $quantity = $item->{"Количество"}  >= 0 ? $item->{"Количество"} : 0;
                $update['stocks'][] = ['offer_id' => $getItem->offer_id, 'product_id' => (int)$getItem->product_id, 'stock' =>  $quantity, 'warehouse_id' => config('ozonupdatestock.wh_id')];
            }
        }
        OzonUpdateStock::update($update);
    }
}
```
## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email islomzoda20@yandex.ru instead of using the issue tracker.

## Credits

- [Kuzibaev Muhammad][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/islomzoda/ozonupdatestock.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/islomzoda/ozonupdatestock.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/islomzoda/ozonupdatestock/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/islomzoda/ozonupdatestock
[link-downloads]: https://packagist.org/packages/islomzoda/ozonupdatestock
[link-travis]: https://travis-ci.org/islomzoda/ozonupdatestock
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/ozonupdatestock*
[link-contributors]: ../../contributors
