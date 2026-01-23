<?php

namespace Daga\Erp\Http\Controllers;

use Dagasmart\BizAdmin\Renderers\Page;
use Dagasmart\BizAdmin\Renderers\Form;
use Dagasmart\BizAdmin\Controllers\AdminController;
use Daga\Erp\Services\ErpBasicCrmService;

/**
 * 客户表
 *
 * @property ErpBasicCrmService $service
 */
class ErpBasicCrmController extends AdminController
{
    protected string $serviceName = ErpBasicCrmService::class;

    public function list(): Page
    {
        $crud = $this->baseCRUD()
            ->filterTogglable()
			->headerToolbar([
				$this->createButton(true, 'lg'),
				...$this->baseHeaderToolBar()
			])
            ->autoFillHeight(true)
            ->columns([
                amis()->TableColumn('id', 'ID')->set('fixed','left')->sortable(),
				amis()->TableColumn('crm_name', '姓名')->searchable()->width(100)->set('fixed','left'),
				amis()->TableColumn('crm_type', '类型')
                    ->sortable()
                    ->type('mapping')
                    ->map([
                        1=>['label'=>'本地客户','color'=>'#f00'],
                        2=>['label'=>'线上会员','color'=>'yellowgreen'],
                    ]),
				amis()->TableColumn('crm_sex', '性别')
                    ->sortable()
                    ->type('mapping')
                    ->map([
                        1=>['label'=>'男','color'=>'yellowgreen'],
                        2=>['label'=>'女','color'=>'lightgray'],
                        3=>['label'=>'保密','color'=>'darkorange'],
                    ]),
				amis()->TableColumn('crm_tel', '联系电话')
                    ->searchable(['type'=>'input-text']),
				amis()->TableColumn('crm_area', '地区ID')
                    ->searchable(['name'=>'crm_area','type'=>'input-city'])
                    ->quickEdit(['type'=>'input-city','value'=>'${crm_area}'])
                    ->set('type','input-city')
                    ->set('static',true)
                    ->sortable(),
				amis()->TableColumn('crm_address', '常住地址'),
				amis()->TableColumn('crm_email', '电子邮箱'),
				amis()->TableColumn('crm_level', '等级')
                    ->searchable(['type'=>'checkboxes','options'=>$this->service->level()])
                    ->sortable()
                    ->type('mapping')
                    ->map([
                        1=>['label'=>'普通','color'=>'yellowgreen'],
                        2=>['label'=>'VIP','color'=>'lightgray'],
                    ]),
				amis()->TableColumn('crm_consume', '消费总金额')->quickEdit(['type'=>'input-number','step'=>'0.01']),
				amis()->TableColumn('crm_point', '获取积分')->sortable(),
				amis()->TableColumn('crm_state', '状态')
                    ->type('switch')
                    ->searchable(['type'=>'select','clearable'=>true,'options'=>[['label'=>'禁用', 'value'=>0],['label'=>'开启', 'value'=>1]]]),
				amis()->TableColumn('crm_recode', '推荐码'),
				amis()->TableColumn('created_at', __('admin.created_at'))->set('type', 'datetime')->sortable(),
				amis()->TableColumn('updated_at', __('admin.updated_at'))->set('type', 'datetime')->sortable(),
                $this->rowActions(true, 'lg')->set('fixed','right')
            ]);

        return $this->baseList($crud);
    }

    public function form($isEdit = false): Form
    {
        return $this->baseForm()->columnCount(2)->data(['prefix'=>admin_user()->mer_id])->body([
            amis()->TextControl('crm_name', '姓名')->required(),
			amis()->ButtonGroupControl('crm_type','类型')
                ->options([
                    ['label'=>'本地客户', 'value'=>1],
                    ['label'=>'线上会员', 'value'=>2],
                ])
                ->value(1)
                ->required(),
            amis()->RadiosControl('crm_sex','性别')
                ->options([1=>'男',2=>'女',3=>'保密'])
                ->value(3)
                ->required(),
			amis()->NumberControl('crm_tel', '联系电话')->required(),
			amis()->InputCityControl('crm_area', '地区ID')->searchable()->required(),
			amis()->TextControl('crm_address', '常住地址'),
			amis()->TextControl('crm_email', '电子邮箱')->type('input-email'),
			amis()->RadiosControl('crm_level', '等级')
                ->options($this->service->level())
                ->value(1)
                ->required(),
			amis()->NumberControl('crm_consume', '消费总金额')
                ->step('0.01')
                ->suffix('元')
                ->value(0.00)
                ->required(),
			amis()->NumberControl('crm_point', '获取积分')
                ->value(0)
                ->min(0)
                ->required(),
			amis()->SwitchControl('crm_state', '状态')->value(1)->required(),
			amis()->TextControl('crm_recode', '推荐码')
                ->readOnly()
                ->addOn(
                    amis()->VanillaAction()->label('随机')->icon('fa-solid fa-shuffle')
                        ->onEvent([
                            'click' => [
                                'actions' => [
                                    [
                                        'actionType'    => 'setValue',
                                        'componentName' => 'crm_recode',
                                        'args'          => [
                                            'value'     => '${prefix + RAND() | base64Encode | lowerCase}',
                                        ],
                                    ],
                                ],
                            ],
                        ])
                )->required(),
        ]);
    }

    public function detail(): Form
    {
        return $this->baseDetail()->columnCount(3)->body([
            amis()->TextControl('id', 'ID')->static(),
			amis()->TextControl('crm_name', '姓名')->static(),
			amis()->RadiosControl('crm_type','类型')->options([1=>'本地客户',2=>'线上会员'])->disabled(),
			amis()->RadiosControl('crm_sex', '性别')->options([1=>'男',2=>'女',3=>'保密'])->disabled(),
			amis()->TextControl('crm_tel', '联系电话')->static(),
			amis()->InputCityControl('crm_area', '地区ID')->static(),
			amis()->TextControl('crm_address', '常住地址')->static(),
			amis()->TextControl('crm_email', '电子邮箱')->static(),
			amis()->RadiosControl('crm_level', '等级')->options([1=>'普通',2=>'VIP'])->disabled(),
			amis()->TextControl('crm_consume', '消费总金额')->static(),
			amis()->TextControl('crm_point', '获得积分')->static(),
			amis()->SwitchControl('crm_state', '状态')->disabled(),
			amis()->TextControl('crm_recode', '推荐码')->static(),
			amis()->TextControl('created_at', __('admin.created_at'))->static(),
			amis()->TextControl('updated_at', __('admin.updated_at'))->static()
        ]);
    }
}
