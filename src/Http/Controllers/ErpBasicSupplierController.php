<?php

namespace Daga\Erp\Http\Controllers;

use Dagasmart\BizAdmin\Renderers\Page;
use Dagasmart\BizAdmin\Renderers\Form;
use Dagasmart\BizAdmin\Controllers\AdminController;
use Daga\Erp\Services\ErpBasicSupplierService;

/**
 * 供货商表
 *
 * @property ErpBasicSupplierService $service
 */
class ErpBasicSupplierController extends AdminController
{
    protected string $serviceName = ErpBasicSupplierService::class;

    public function list(): Page
    {
        $crud = $this->baseCRUD()
            ->filterTogglable(false)
			->headerToolbar([
				$this->createButton(true,'md'),
				...$this->baseHeaderToolBar()
			])
            ->autoFillHeight(true)
            ->columns([
                amis()->TableColumn('id', 'ID')->fixed('left')->sortable(),
				amis()->TableColumn('sup_name', '供货商')->searchable()->fixed('left'),
				amis()->TableColumn('sup_company', '公司名称'),
				amis()->TableColumn('sup_legal', '负责人'),
				amis()->TableColumn('sup_scope', '经营范围'),
				amis()->TableColumn('sup_man', '联系人'),
				amis()->TableColumn('sup_phone', '联系电话'),
				amis()->TableColumn('sup_email', '电子邮箱'),
				amis()->TableColumn('sup_qq', 'qq号码'),
                amis()->TableColumn('sup_area', '地区ID')
                    ->searchable(['name'=>'sup_area','type'=>'input-city'])
                    ->quickEdit(['type'=>'input-city','value'=>'${sup_area}'])
                    ->set('type','input-city')
                    ->set('static',true)
                    ->sortable(),
                amis()->TableColumn('sup_address', '公司地址'),
				amis()->TableColumn('sup_current_pay', '当前应付款'),
				amis()->TableColumn('sup_init_pay', '初始应付款'),
				amis()->TableColumn('sup_desc', '备注'),
                //amis()->TableColumn('mer_id', '商户id'),
				amis()->TableColumn('created_at', __('admin.created_at'))->set('type', 'datetime')->sortable(),
				amis()->TableColumn('updated_at', __('admin.updated_at'))->set('type', 'datetime')->sortable(),
                $this->rowActions(true,'md')->fixed('right')
            ]);

        return $this->baseList($crud);
    }

    public function form($isEdit = false): Form
    {
        return $this->baseForm()->mode('normal')->body([
            amis()->GroupControl()->body([
                amis()->TextControl('sup_name', '供货商')->required(),
                amis()->TextControl('sup_company', '公司名称')->required(),
            ]),
            amis()->GroupControl()->body([
                amis()->TextControl('sup_legal', '负责人')->required(),
                amis()->TextControl('sup_man', '联系人')->required(),
                amis()->TextControl('sup_phone', '联系电话')->required(),
            ]),
            amis()->GroupControl()->body([
                amis()->TextControl('sup_email', '电子邮箱'),
                amis()->TextControl('sup_qq', 'qq号码'),
                amis()->TextControl('sup_zip_code', '邮政编码'),
            ]),

            amis()->TextareaControl('sup_scope', '经营范围'),

            amis()->GroupControl()->body([
                amis()->InputCityControl('sup_area', '地区ID')->required(),
                amis()->TextControl('sup_address', '公司地址')->required(),
            ]),
            amis()->GroupControl()->body([
                amis()->TextControl('sup_current_pay', '当前应付款')
                    ->type('native-number')
                    ->value(0)
                    ->step(0.01)
                    ->suffix('元')
                    ->required(),
                amis()->TextControl('sup_init_pay', '初始应付款')
                    ->type('native-number')
                    ->value(0)
                    ->step(0.01)
                    ->suffix('元')
                    ->required(),
            ]),
			amis()->TextareaControl('sup_desc', '备注')
        ]);
    }

    public function detail(): Form
    {
        return $this->baseDetail()->body([
            amis()->TextControl('id', 'ID')->static(),
			amis()->TextControl('sup_name', '供货商')->static(),
			amis()->TextControl('sup_company', '公司名称')->static(),
			amis()->TextControl('sup_legal', '负责人')->static(),
			amis()->TextControl('sup_scope', '经营范围')->static(),
			amis()->TextControl('sup_man', '联系人')->static(),
			amis()->TextControl('sup_phone', '联系电话')->static(),
			amis()->TextControl('sup_email', '电子邮箱')->static(),
			amis()->TextControl('sup_qq', 'qq号码')->static(),
			amis()->TextControl('sup_zip_code', '邮政编码')->static(),
			amis()->TextControl('sup_address', '公司地址')->static(),
			amis()->TextControl('sup_current_pay', '当前应付款')->static(),
			amis()->TextControl('sup_init_pay', '初始应付款')->static(),
			amis()->TextControl('sup_desc', '备注')->static(),
            amis()->TextControl('mer_id', '商户id')->static(),
			amis()->TextControl('created_at', __('admin.created_at'))->static(),
			amis()->TextControl('updated_at', __('admin.updated_at'))->static()
        ]);
    }
}
