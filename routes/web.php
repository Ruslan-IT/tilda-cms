<?php

use App\Http\Controllers\CustomDiskController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\InformationBlock;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::post('/custom-disk/send', [CustomDiskController::class, 'send'])->name('custom-disk.send');


Route::post('/order/send', [OrderController::class, 'send']);


Route::get('/', function () {
    $products = Product::all();
    $settings = SiteSetting::first();

    $infoBlock = InformationBlock::first();
    $infoBlock2 = InformationBlock::find(2);
    $infoBlock3 = InformationBlock::find(3);

    //   {!! $infoBlock->content  !!}
    return view('pages.home',
        compact(
        'products',
        'settings',
            'infoBlock',
            'infoBlock2',
            'infoBlock3'

    ));
});
