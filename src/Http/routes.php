<?php

use Daga\Erp\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('erp', [Controllers\ErpController::class, 'index']);

Route::prefix('daga')->group(function () {
    Route::prefix('erp')->group(function () {
        //基础路由
        Route::prefix('basic')->group(function () {
            //客户
            Route::resource('crm', Controllers\ErpBasicCrmController::class);
            //仓库
            Route::resource('depos', Controllers\ErpBasicDeposController::class);
            //供应商
            Route::resource('supplier', Controllers\ErpBasicSupplierController::class);
            //产品
            Route::prefix('product')->group(function () {
                //产品档案
                Route::resource('list', Controllers\ErpBasicProductController::class);
                // 产品分类
                Route::resource('cate', Controllers\ErpBasicProductCateController::class);
                // 产品分类树ID
                Route::get('tree/options', [Controllers\ErpBasicProductCateController::class,'treeOptions']);
                //产品单位
                Route::resource('unit', Controllers\ErpBasicProductUnitController::class);
                //产品类型
                Route::resource('type', Controllers\ErpBasicProductUnitController::class);
                //供货商产品列表api
                Route::get('sup/api/{sup_id}', [Controllers\ErpBasicProductController::class, 'supApi']);
            });
        });
        //业务路由
        Route::prefix('workflow')->group(function () {
            //采购
            Route::prefix('purchase')->group(function () {
                //采购订单
                Route::resource('order', Controllers\ErpPurchaseOrderController::class);
            });
        });
    });
});
