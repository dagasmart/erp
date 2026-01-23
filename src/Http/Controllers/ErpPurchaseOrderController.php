<?php

namespace Daga\Erp\Http\Controllers;

use Daga\Erp\Services\ErpBasicSupplierService;
use Dagasmart\BizAdmin\Renderers\Alert;
use Dagasmart\BizAdmin\Renderers\Page;
use Dagasmart\BizAdmin\Renderers\Form;
use Dagasmart\BizAdmin\Controllers\AdminController;
use Daga\Erp\Services\ErpPurchaseOrderService;

/**
 * 采购订单表
 *
 * @property ErpPurchaseOrderService $service
 */
class ErpPurchaseOrderController extends AdminController
{
    protected string $serviceName = ErpPurchaseOrderService::class;

    public function list(): Page
    {
        $crud = $this->baseCRUD()
            ->filterTogglable(false)
			->headerToolbar([
				$this->createButton(true, 'lg'),
				...$this->baseHeaderToolBar(),
                // 导入按钮
                amis()->Button()->label('导入'),
			])
            ->autoFillHeight(true)
            ->columns([
                amis()->TableColumn('id', 'ID')->sortable(),
				amis()->TableColumn('order_no', '订单号')->set('fixed','left'),
				amis()->TableColumn('sup_id', '供应商')
                    ->set('type','select')
                    ->set('options',ErpBasicSupplierService::pluck('sup_name','id'))
                    ->set('static',true),
				//amis()->TableColumn('check_status', '核查状态'),
                amis()->TableColumn('other', '备注'),
				amis()->TableColumn('user_as', '创建者'),
				//amis()->TableColumn('audit_status', '审核状态'),
                amis()->TableColumn('state', '状态')
                    ->set('type','select')
                    ->set('options',$this->service::stateOption(true,'${user_id}'))
                    ->set('static',true),
				amis()->TableColumn('created_at', '业务日期')->set('type', 'datetime')->sortable(),
                amis()->TableColumn('finished_at', '订单完成时间'),
                $this->rowActions(true, 'lg')->set('fixed','right')
            ]);

        return $this->baseList($crud);
    }

    /**
     * order_no 首字母 + 日期 + 用户ID + 毫秒时间戳
     * @param bool $isEdit
     * @return Form
     */
    public function form(bool $isEdit = false): Form
    {
        amis()->Watermark()->body([
            amis()->TextControl()
        ])
        ->width(160) // 设置宽度
        ->height(96) // 设置高度
        ->className('p-25 right-0 top-0') // eg: 添加内边距
        ->rotate(-16) // 设置旋转角度
        ->zIndex(999) // 设置 z-index
        //->image('storage/images/stamp_1.png') // 可以设置图片
        ->content('已审核') // 设置水印的文字内容
        ->font([ // 文字样式
            'color' => 'red',
            'fontSize' => 10
        ])
        ->offset(0)
        ->gap([0, 0]); // 设置水印之间的间距

        return $this->baseForm()->mode('normal')->data(['prefix'=>'CG'.date('Ymd').admin_user()->id])->body([
            amis()->GroupControl()
                ->body([

                    amis()->GroupControl()->direction('vertical')
                        ->className('border-solid p-5 border border-blue-500 rounded-xl shadow-lg')
                        ->body([
                            Alert::make()
                                ->showIcon()
                                ->level('warning')
                                ->showCloseButton()
                                ->body("基本信息"),
                            amis()->TextControl('order_no', '订单号')
                                ->value('${ prefix + INT(NOW()) | upperCase }')
                                ->readOnly()
                                ->required(),
                            amis()->TextControl('created_at', '业务日期')
                                ->value(date('Y-m-d H:i:s'))
                                ->readOnly()
                                ->required(),
                            amis()->SelectControl('sup_id', '供应商')
                                ->options($this->service::supplier('sup_name','id'))
                                ->searchable()
                                ->clearable()
                                ->required(),
                        ]),
                    amis()->GroupControl()->direction('vertical')->body([
                        amis()->GroupControl()
                            ->direction('vertical')
                            ->className('border-solid p border rounded-xl shadow-lg')
                            ->body([
                                amis()->GroupControl()->body([
                                amis()->TextControl('user_id', '创建人')
                                    ->hidden()
                                    ->value(admin_user()->id)
                                    ->required(),
                                amis()->TextControl('user_as', '创建人')
                                    ->readOnly()
                                    ->value(admin_user()->name)
                                    ->required(),
//                                amis()->TextControl('mer_id', '商户id')
//                                    ->visible(!admin_user()->mer_id)
//                                    ->readOnly()
//                                    ->value(admin_user()->mer_id)
//                                    ->required(),
                                ]),
                                amis()->RadiosControl('state', '单据状态')
                                    ->options($this->service::stateOption($isEdit,'${user_id}'))
                                    ->removable()
                                    ->selectFirst()
                                    ->required(),
                            ]),
                        amis()->GroupControl()
                            ->direction('vertical')
                            ->className('border-solid p border rounded-xl shadow-lg')
                            ->body([
                                amis()->TextareaControl('other', '备注')->placeholder('采购情况说明'),
                            ]),
                    ]),

            ]),

            amis()->GroupControl()->body([
                amis()->FieldSetControl()->title('采购清单')
                    ->collapsable(1)
                    ->collapsed(0)
                    ->size('md')
                    ->body([
                        amis()->ButtonToolbar()
                            ->buttons([
                                [
                                    amis()->Button()
                                        ->level('primary')
                                        ->label('从产品库选购')
                                        ->icon('fa fa-cart-plus')
                                        ->size('sm')
                                        ->actionType('drawer')
                                        ->drawer([
                                            'closeOnOutside'=> true,
                                            'resizable'=> true,
                                            'title'=> '产品库',
                                            'size'=> 'lg',
                                            'actions'=> [],
                                            'body'=> [
                                                amis()->CRUDTable()
                                                    ->syncLocation(false)
                                                    ->onEvent([
                                                        'selectedChange'=> [
                                                            'actions'=> [
                                                                [
                                                                    'actionType'=>'toast',
                                                                    'args'=>[
                                                                        //'msg'=>'已选择${event.data.selectedItems.length}条记录'
                                                                        'msg'=>'${event.data.item.name|json}'
                                                                    ]
                                                                ],
                                                                [
                                                                    'actionType'=>'addItem',
                                                                    'groupType'=> 'component',
                                                                    'componentId'=>'product_order_combo',
                                                                    'args'=>[
                                                                        'item'=>[
                                                                            'name_as'=>'${event.data.item.name}',
                                                                            'item_no'=>'${event.data.item.item_no}',
                                                                            'attr_id'=>'${event.data.item.unit_id}',
                                                                            'cost_price'=>'${event.data.item.unit_id}',
                                                                            'number'=>'${event.data.item.unit_id}',
                                                                            'price'=>'${event.data.item.unit_id}',
                                                                        ]
                                                                    ]
                                                                ],
                                                            ]
                                                        ]
                                                    ])
                                                    ->api('daga/erp/basic/product/sup/api/${sup_id|null}')
                                                    ->defaultParams(['perPage'=>50])
                                                    ->headerToolbar([
                                                        ...$this->baseHeaderToolBar()
                                                    ])
                                                    ->bulkActions([
                                                        [
                                                            'level'=> 'link',
                                                            'size'=> 'xs'
                                                        ]
                                                    ])
                                                    ->keepItemSelectionOnPageChange()//已选n条
                                                    ->autoFillHeight(true)
                                                    ->checkOnItemClick(true)//行选中
                                                    ->columns([
                                                        amis()->TableColumn('id', 'ID')->sortable(),
                                                        amis()->TableColumn('name', '产品名称')->searchable(),
                                                        amis()->TableColumn('py_code', '拼音码'),
                                                        amis()->TableColumn('item_no', '产品编号')->searchable()->sortable(),
                                                        amis()->TableColumn('type_as', '类型'),
                                                        amis()->TableColumn('unit_as', '单位'),
                                                    ]),

                                            ]
                                        ]),

                                    amis()->Button()
                                        ->label('清空')
                                        ->actionType('dialog')
                                        ->dialog([
                                            'closeOnEsc'=>true,
                                            'closeOnOutside'=>true,
                                            'title'=>'确认提示',
                                            'body'=>'是否清空已选产品数据?',
                                            "onEvent"=> [
                                                'confirm'=> [
                                                    'actions'=> [
                                                        [
                                                            'componentId'=> 'product_order_combo',
                                                            'groupType'=> 'component',
                                                            'actionType'=> 'clear'
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ])

                                ]
                            ]),
                        amis()->ComboControl('combo')
                            ->id('comboId')
                            ->removable()
                            ->items([
                                amis()->TableControl('product_order_combo')
                                    ->id('product_order_combo')
                                    ->affixHeader()
                                    ->columnsTogglable(false)
                                    ->combineFromIndex(0)
                                    ->combineNum(1)
                                    ->addable()
                                    ->editable()
                                    ->showIndex()
                                    ->draggable(false)
                                    ->removable()
                                    ->copyable()
                                    ->perPage(50)
                                    ->onEvent([
                                        'change'=> [
                                            'actions'=> [
                                                    'actionType'=> 'setValue',
                                                    'componentId'=> 'rows_numbers',
                                                    'args'=> [
                                                        ['value'=> '78967']
                                                    ]

                                            ]
                                        ]
                                    ])
                                    ->affixRow([
                                        [
                                            'type'=> 'text',
                                            'text'=> '总计',
                                            'colSpan'=> 6
                                        ],
                                        [
                                            'type'=> 'text',
                                            'id'=>'rows_numbers',
                                            'value'=> '${SUM(rows.price)}',
                                            'colSpan'=> 6
                                        ]
                                    ])
                                    ->showTableAddBtn()
                                    ->columns([
                                        amis()->TableColumn('name_as', '产品名称')
                                            ->quickEdit([
                                                'type'=> 'select',
                                                'searchable'=> true,
                                                'selectMode'=> 'table',
                                                'columns'=> [
                                                    ['name'=>'name','label'=>'商品名称'],
                                                    ['name'=>'value','label'=>'商品编号']
                                                ],
                                                'options'=> ErpPurchaseOrderService::product(),
                                                'onEvent'=> [
                                                    'change'=> [
                                                        'actions'=> [
                                                            [
                                                                'actionType'=> 'toast',
                                                                'componentId'=> 'item_no',
                                                                'args'=> [
                                                                    'msg'=> '${isEdit|json}'
                                                                ]
                                                            ]

                                                        ]
                                                    ]
                                                ]
                                            ]),
                                        amis()->TableColumn('item_no', '产品编号')
                                            ->quickEdit([
                                                'type'=> 'input-text',
                                                'id'=> 'item_no',
                                                'readOnly'=> true,
                                                //'required'=> true,
                                            ])
                                            ->sortable(),
//                                        amis()->TableColumn('type_as', '类型')
//                                            ->quickEdit([
//                                                'type'=>'select',
//                                                'options'=>ErpPurchaseOrderService::type(),
//                                                'required'=>true
//                                            ]),
//                                        amis()->TableColumn('unit_as', '单位')
//                                            ->quickEdit([
//                                                'type'=>'select',
//                                                'options'=>ErpPurchaseOrderService::unit(),
//                                                'required'=>true
//                                            ]),
                                        amis()->TableColumn('attr_id', '规格属性'),
                                        amis()->TableColumn('cost_price', '价格')
                                            ->value(0.00)
                                            ->quickEdit([
                                                'type'=> 'input-number',
                                                'min'=> 0,
                                                'step'=> 0.01
                                            ]),
                                        amis()->TableColumn('number', '数量')
                                            ->value(1)
                                            ->quickEdit([
                                                'type'=> 'input-number',
                                                'min'=> 1
                                            ]),
                                        amis()->TableColumn('price', '金额')
                                            ->quickEdit([
                                                'type'=> 'input-text',
                                                'readOnly'=> true,
                                                'min'=> 1,
                                                'step'=> 0.01,
                                                'value'=> '${cost_price * number}',
                                            ]),
                                        //amis()->Operation()->label('操作'),
                                    ]),


                            ])->removable(),
                    ])
            ]),


			//amis()->SwitchControl('check_status', '核查状态')->value(0),
			//amis()->TextControl('audit_status', '审核状态')->value(0),
//			amis()->TextControl('finished_at', '订单完成时间'),
        ]);
    }

    public function detail(): Form
    {
        return $this->baseDetail()->body([
            amis()->TextControl('id', 'ID')->static(),
			amis()->SelectControl('order_no', '订单单号')->static(),
			amis()->SelectControl('sup_id', '供应商id')->options(ErpBasicSupplierService::pluck('sup_name','id'))->static(),
			amis()->TextControl('state', '状态')->static(),
			amis()->TextControl('other', '备注')->static(),
			amis()->TextControl('check_status', '核实状态')->static(),
			amis()->TextControl('user_id', '创建订单用户')->static(),
			amis()->TextControl('audit_status', '审核状态')->static(),
			amis()->TextControl('finished_at', '订单完成时间')->static(),
			amis()->TextControl('created_at', __('admin.created_at'))->static(),
			amis()->TextControl('updated_at', __('admin.updated_at'))->static()
        ]);
    }
}
