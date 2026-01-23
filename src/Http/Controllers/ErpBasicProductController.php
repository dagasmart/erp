<?php

namespace Daga\Erp\Http\Controllers;

use Dagasmart\BizAdmin\Extend\Sku;
use Dagasmart\BizAdmin\Renderers\Page;
use Dagasmart\BizAdmin\Renderers\Form;
use Dagasmart\BizAdmin\Controllers\AdminController;
use Daga\Erp\Services\ErpBasicProductService;

/**
 * 产品档案表
 *
 * @property ErpBasicProductService $service
 */
class ErpBasicProductController extends AdminController
{
    protected string $serviceName = ErpBasicProductService::class;

    public function list(): Page
    {
        $crud = $this->baseCRUD()
            ->filterTogglable()
			->headerToolbar([
				$this->createButton(true),
				...$this->baseHeaderToolBar()
			])
            ->autoFillHeight(true)
            ->columns([
                amis()->TableColumn('id', 'ID')->sortable(),
				amis()->TableColumn('name', '产品名称')->searchable(),
				amis()->TableColumn('py_code', '拼音码'),
				amis()->TableColumn('item_no', '产品编号')->searchable()->sortable(),
				amis()->TableColumn('type_as', '类型')
                    ->searchable([
                        'type'=>'radios',
                        'name'=>'type',
                        'options'=>ErpBasicProductService::type(),
                        'searchable'=>true,
                        'clearable'=>true
                    ]),
                amis()->TableColumn('unit_as', '单位'),
                amis()->TableColumn('sup_as', '供货商')
                    ->searchable([
                        'type'=>'select',
                        'name'=>'sup_id',
                        'options'=>ErpBasicProductService::supplier(),
                        'searchable'=>true,
                        'clearable'=>true
                    ]),
				amis()->TableColumn('created_at', __('admin.created_at'))->set('type', 'datetime')->sortable(),
				amis()->TableColumn('updated_at', __('admin.updated_at'))->set('type', 'datetime')->sortable(),
                $this->rowActions(true)
            ]);
        return $this->baseList($crud);
    }

    public function form($isEdit = false): Form
    {
        return $this->baseForm()
            ->mode('normal')
            ->data([])
            ->body([
                amis()->GroupControl()->direction('vertical')->body([
                    amis()->InputGroupControl('sup_id','供货商')->body([
                        amis()->SelectControl('sup_id','供货商')
                            ->searchable()
                            ->options(ErpBasicProductService::supplier())
                            ->required(),
                        amis()->Button()->icon('fa fa-ellipsis')->tooltip('管理'),
                    ]),
                ]),
                amis()->GroupControl()->body([
                    amis()->TextControl('name', '产品名称')
                        ->required(),
                    amis()->TextControl('item_no', '产品编号')
                        ->readOnly()
                        ->value(ErpBasicProductService::itemNoGen())
                        ->required(),
                ]),
                amis()->GroupControl()->body([
                    amis()->InputGroupControl('type','类型')->body([
                        amis()->SelectControl('type', '类型')
                            ->size('sm')
                            ->options(ErpBasicProductService::type()),
                        amis()->Button()->icon('fa fa-ellipsis')->tooltip('管理'),
                    ]),
                    amis()->InputGroupControl('unit_id','单位')->body([
                        amis()->SelectControl('unit_id', '单位')
                            ->searchable()
                            ->size('sm')
                            ->options(ErpBasicProductService::unit('name', 'id')),
                        amis()->Button()->icon('fa fa-list-ul')->tooltip('管理'),
                    ]),
                ]),
                amis()->GroupControl()->body([
                    amis()->FieldSetControl()->title('基本设置')
                        ->collapsable(1)
                        ->collapsed(1)
                        ->body([
                            amis()->GroupControl()->body([
                                amis()->GroupControl()->direction('vertical')->body([
                                    amis()->InputGroupControl('brand','品牌')->body([
                                        amis()->SelectControl('brand','品牌')
                                            ->searchable()
                                            ->size('sm')
                                            ->options(['abc','def','xyz']),
                                        amis()->Button()->icon('fa fa-folder-closed')->tooltip('管理'),
                                    ]),
                                    amis()->TreeSelectControl('cate_id', '分类')
                                        ->source(admin_url('daga/erp/basic/product/tree/options?id=${id}'))
                                        ->required(),
                                ]),
                                amis()->ImageControl('image_url', '主图'),
                                amis()->TextControl('image', '主图')->hidden()->value('${image_url}'),
                            ]),
                            amis()->FieldSetControl()->title('多图')
                                ->collapsable(1)
                                ->collapsed(0)
                                ->size('md')
                                ->body([
                                    amis()->ImageControl('slider_image_url')->width('10')->maxLength(6)->multiple()->draggable()->desc('最多允许上传6张'),
                                    amis()->TextControl('slider_image')->hidden()->value('${slider_image_url}'),
                                ])
                        ])
                ]),

                amis()->GroupControl()->mode('inline')->body([
                    amis()->SwitchControl('is_spec','多规格')
                        ->onText('是')
                        ->offText('否')
                        ->value(),
                ]),
                amis()->GroupControl()->body([
                    amis()->FieldSetControl()->title('规格配置')
                        ->visibleOn('${is_spec==1}')
                        ->collapsable(1)
                        ->collapsed(0)
                        ->size('md')
                        ->body([
                            // 使用组件
                            Sku::make()->form(),


                        ])
                ]),
                amis()->FieldSetControl()->title('产品描述')
                    ->collapsable(1)
                    ->collapsed(1)
                    ->body([
                        amis()->WangEditor('detail')->required()
                    ])



            ]);
    }


    public function detail(): Form
    {
        return $this->baseDetail()->data([
            'unit_list' => ErpBasicProductService::unit('name', 'id')
        ])->body([
            amis()->TextControl('id', 'ID')->static(),
			amis()->TextControl('name', '产品名称')->static(),
			amis()->TextControl('py_code', '拼音码')->static(),
			amis()->TextControl('item_no', '产品编号')->static(),
			amis()->SelectControl('type', '类型')
                ->options(ErpBasicProductService::type())
                ->static(),
            amis()->SelectControl('unit_id', '单位')
                ->options(ErpBasicProductService::unit('name', 'id'))
                ->static(),
            amis()->SelectControl('sup_id', '供货商')
                ->options(ErpBasicProductService::supplier())
                ->static(),
			amis()->TextControl('created_at', __('admin.created_at'))->static(),
			amis()->TextControl('updated_at', __('admin.updated_at'))->static()
        ]);
    }


    public function supApi($sup_id): array
    {
        $service = new ErpBasicProductService;
        return $service->supApi($sup_id);
    }


}
