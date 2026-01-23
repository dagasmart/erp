<?php

namespace Daga\Erp;

use Illuminate\Support\Facades\Redis;
use DagaSmart\BizAdmin\Renderers\Form;
use DagaSmart\BizAdmin\Renderers\TextControl;
use DagaSmart\BizAdmin\Extend\ServiceProvider;

class ErpServiceProvider extends ServiceProvider
{
    protected $menu = [
        [
            'parent' => NULL,
            'title' => '财务进销存',
            'url' => '/daga/erp',
            'url_type' => 1,
            'icon' => 'arcticons:home-finance',
        ],
        [
            'parent' => '财务进销存',
            'title' => '基础维护',
            'url' => '/daga/erp/basic',
            'url_type' => 1,
            'icon' => 'arcticons:eufyhome',
        ],
        [
            'parent' => '基础维护',
            'title' => '客户',
            'url' => '/daga/erp/basic/crm',
            'url_type' => 1,
            'icon' => 'mdi-light:account',
        ],
        [
            'parent' => '基础维护',
            'title' => '产品',
            'url' => '/daga/erp/basic/product',
            'url_type' => 1,
            'icon' => 'mdi-light:label',
        ],
        [
            'parent' => '产品',
            'title' => '产品档案',
            'url' => '/daga/erp/basic/product/list',
            'url_type' => 1,
            'icon' => 'mdi-light:label',
        ],
        [
            'parent' => '产品',
            'title' => '产品分类',
            'url' => '/daga/erp/basic/product/cate',
            'url_type' => 1,
            'icon' => 'mdi-light:format-list-bulleted',
        ],
        [
            'parent' => '产品',
            'title' => '产品单位',
            'url' => '/daga/erp/basic/product/unit',
            'url_type' => 1,
            'icon' => 'mdi-light:taco',
        ],
        [
            'parent' => '产品',
            'title' => '产品规格',
            'url' => '/daga/erp/basic/product/spec',
            'url_type' => 1,
            'icon' => 'mdi-light:format-align-middle',
        ],
        [
            'parent' => '基础维护',
            'title' => '仓库',
            'url' => '/daga/erp/basic/depos',
            'url_type' => 1,
            'icon' => 'fluent:home-more-20-regular',
        ],
        [
            'parent' => '基础维护',
            'title' => '供货商',
            'url' => '/daga/erp/basic/supplier',
            'url_type' => 1,
            'icon' => 'basil:user-outline',
        ],
        [
            'parent' => '财务进销存',
            'title' => '采购管理',
            'url' => '/daga/erp/workflow/purchase',
            'url_type' => 1,
            'icon' => 'mdi-light:content-duplicate',
        ],
        [
            'parent' => '采购管理',
            'title' => '采购订单',
            'url' => '/daga/erp/workflow/purchase/order',
            'url_type' => 1,
            'icon' => 'mdi-light:note-text',
        ],
        [
            'parent' => '采购管理',
            'title' => '采购入库',
            'url' => '/daga/erp/workflow/purchase/inventory',
            'url_type' => 1,
            'icon' => 'mdi-light:cart',
        ],
        [
            'parent' => '采购管理',
            'title' => '采购退货',
            'url' => '/daga/erp/workflow/purchase/cancel',
            'url_type' => 1,
            'icon' => 'mynaui:cart-minus',
        ],
        [
            'parent' => '财务进销存',
            'title' => '销售管理',
            'url' => '/daga/erp/workflow/sell',
            'url_type' => 1,
            'icon' => 'mdi-light:equalizer',
        ],
        [
            'parent' => '销售管理',
            'title' => '销售订单',
            'url' => '/daga/erp/workflow/sell/order',
            'url_type' => 1,
            'icon' => 'solar:ticket-sale-outline',
        ],
        [
            'parent' => '销售管理',
            'title' => '开单出库',
            'url' => '/daga/erp/workflow/sell/out',
            'url_type' => 1,
            'icon' => 'ci:home-minus',
        ],
        [
            'parent' => '销售管理',
            'title' => '销售退货',
            'url' => '/daga/erp/workflow/sell/cancel',
            'url_type' => 1,
            'icon' => 'ci:home-plus',
        ],
        [
            'parent' => '财务进销存',
            'title' => '库存管理',
            'url' => '/daga/erp/workflow/depos',
            'url_type' => 1,
            'icon' => 'mdi-light:nfc-variant',
        ],
        [
            'parent' => '库存管理',
            'title' => '库存盘点',
            'url' => '/daga/erp/workflow/depos/inventory',
            'url_type' => 1,
            'icon' => 'arcticons:adguard-home-manager',
        ],
        [
            'parent' => '库存管理',
            'title' => '库存调拨',
            'url' => '/daga/erp/workflow/depos/allot',
            'url_type' => 1,
            'icon' => 'mdi-light:truck',
        ],
        [
            'parent' => '库存管理',
            'title' => '库存变动',
            'url' => '/daga/erp/workflow/depos/change',
            'url_type' => 1,
            'icon' => 'mdi-light:repeat',
        ],
        [
            'parent' => '库存管理',
            'title' => '物料管理',
            'url' => '/daga/erp/workflow/depos/materiel',
            'url_type' => 1,
            'icon' => 'mdi-light:hamburger',
        ],
        [
            'parent' => '物料管理',
            'title' => '物料列表',
            'url' => '/daga/erp/workflow/depos/materiel/list',
            'url_type' => 1,
            'icon' => 'mdi-light:format-float-center',
        ],
        [
            'parent' => '物料管理',
            'title' => '领退记录',
            'url' => '/daga/erp/workflow/materiel/log',
            'url_type' => 1,
            'icon' => 'mdi-light:clipboard',
        ],
        [
            'parent' => '库存管理',
            'title' => '生产管理',
            'url' => '/daga/erp/workflow/depos/produce',
            'url_type' => 1,
            'icon' => 'mdi-light:face-mask',
        ],
        [
            'parent' => '财务进销存',
            'title' => '财务管理',
            'url' => '/daga/erp/workflow/finance',
            'url_type' => 1,
            'icon' => 'mdi-light:currency-usd',
        ],
        [
            'parent' => '财务管理',
            'title' => '费用开支',
            'url' => '/daga/erp/workflow/finance/pay/log',
            'url_type' => 1,
            'icon' => 'mynaui:credit-card-minus',
        ],
        [
            'parent' => '财务管理',
            'title' => '应付记账',
            'url' => '/daga/erp/workflow/finance/payable/log',
            'url_type' => 1,
            'icon' => 'mdi-light:format-wrap-inline',
        ],
        [
            'parent' => '财务管理',
            'title' => '应收记账',
            'url' => '/daga/erp/workflow/finance/receivable/log',
            'url_type' => 1,
            'icon' => 'mdi-light:inbox',
        ],
        [
            'parent' => '财务管理',
            'title' => '发票管理',
            'url' => '/daga/erp/workflow/finance/invoice/log',
            'url_type' => 1,
            'icon' => 'mdi-light:wallet',
        ],
        [
            'parent' => '财务管理',
            'title' => '收款单',
            'url' => '/daga/erp/workflow/finance/receipt/log',
            'url_type' => 1,
            'icon' => 'mdi-light:credit-card',
        ],
        [
            'parent' => '财务管理',
            'title' => '付款单',
            'url' => '/daga/erp/workflow/finance/payment/log',
            'url_type' => 1,
            'icon' => 'arcticons:alipay',
        ],
        [
            'parent' => '财务进销存',
            'title' => '统计分析',
            'url' => '/daga/erp/workflow/stat',
            'url_type' => 1,
            'icon' => 'mdi-light:chart-bar',
        ],
        [
            'parent' => '统计分析',
            'title' => '经营分析',
            'url' => '/daga/erp/workflow/stat/operate',
            'url_type' => 1,
            'icon' => 'mdi-light:chart-histogram',
        ],
        [
            'parent' => '经营分析',
            'title' => '采购分析',
            'url' => '/daga/erp/workflow/stat/operate/purchase',
            'url_type' => 1,
            'icon' => 'arcticons:spotistats',
        ],
        [
            'parent' => '经营分析',
            'title' => '销售分析',
            'url' => '/daga/erp/workflow/stat/operate/sell',
            'url_type' => 1,
            'icon' => 'arcticons:heartbeat',
        ],
        [
            'parent' => '经营分析',
            'title' => '库存分析',
            'url' => '/daga/erp/workflow/stat/operate/depos',
            'url_type' => 1,
            'icon' => 'ant-design:bar-chart-outlined',
        ],
        [
            'parent' => '经营分析',
            'title' => '财务分析',
            'url' => '/daga/erp/workflow/stat/operate/finance',
            'url_type' => 1,
            'icon' => 'arcticons:freemobilenetstat',
        ]
    ];

	public function settingForm(): ?Form
    {
	    return $this->baseSettingForm()->body([
            TextControl::make()->name('value')->label('Value')->required(true),
	    ]);
	}


    /**
     * 序列号生成器
     * @param string $prefix
     * @return string
     */
    public static function itemNoGen(string $prefix = ''): string
    {
        return $prefix . date('YmdHis') . admin_user()->id;
    }


}
