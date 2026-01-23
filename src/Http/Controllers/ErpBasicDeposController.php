<?php
namespace Daga\Erp\Http\Controllers;

use Illuminate\Support\Env;
use Dagasmart\BizAdmin\Renderers\Page;
use Dagasmart\BizAdmin\Renderers\Form;
use Dagasmart\BizAdmin\Controllers\AdminController;
use Daga\Erp\Services\ErpBasicDeposService;

/**
 * 仓库表
 *
 * @property ErpBasicDeposService $service
 */
class ErpBasicDeposController extends AdminController
{
    protected string $serviceName = ErpBasicDeposService::class;

    public function list(): Page
    {
        $crud = $this->baseCRUD()
			->headerToolbar([
				$this->createButton(true),
				...$this->baseHeaderToolBar()
			])
            ->filterTogglable()
            ->filter(
                $this->baseFilter()->body([
                    amis()->TextControl('depos_name', '仓库名称')->clearable()->size('md'),
                    amis()->TextControl('depos_volume', '仓库容积')->clearable()->size('md'),
                    amis()->TextControl('depos_square', '仓库面积')->clearable()->size('md'),
                    amis()->TextControl('depos_address', '仓库地址')->clearable()->size('md'),
                ])
            )
            ->autoFillHeight(true)
            ->loadDataOnce()
            ->columns([
                amis()->TableColumn('id', 'ID')->fixed('left')->sortable(),
				amis()->TableColumn('depos_name', '仓库名称')->fixed('left'),
				amis()->TableColumn('depos_volume', '仓库容积')->sortable(),
				amis()->TableColumn('depos_square', '仓库面积')->sortable(),
				amis()->TableColumn('depos_images_url', '仓库图片')->type('images'),
                amis()->TableColumn('depos_area', '地区id')
                    ->searchable(['name'=>'depos_area','type'=>'input-city'])
                    ->quickEdit(['type'=>'input-city','value'=>'${depos_area}'])
                    ->set('type','input-city')
                    ->set('static',true)
                    ->sortable(),
				amis()->TableColumn('depos_address', '仓库地址'),
				amis()->TableColumn('depos_sort', '排序[0-255]')
                    ->quickEdit(['type'=>'number'])
                    ->sortable(),
				amis()->TableColumn('depos_status', '状态')
                    ->set('type','switch')
                    ->set('onText','启用')
                    ->set('offText','停用')
                    ->width(80)
                    ->sortable(),
				amis()->TableColumn('depos_keeper', '仓管员'),
				amis()->TableColumn('depos_tel', '联系电话'),
				amis()->TableColumn('created_at', __('admin.created_at'))->set('type', 'datetime')->sortable(),
				amis()->TableColumn('updated_at', __('admin.updated_at'))->set('type', 'datetime')->sortable(),
                $this->rowActions(true,'md')->set('fixed','right')
            ]);

        return $this->baseList($crud);
    }

    public function form($isEdit = false): Form
    {
        return $this->baseForm()->columnCount(2)->mode('normal')->body([
            amis()->TextControl('depos_name', '仓库名称')->required(),
			amis()->NumberControl('depos_volume', '仓库容积')->step('0.01')->suffix(' M³'),
			amis()->NumberControl('depos_square', '仓库面积')->step('0.01')->suffix(' M²'),
			amis()->ImageControl('depos_images_url', '仓库图片')->disabledOn('${depos_status == 1}'),
			amis()->InputCityControl('depos_area', '地区id')->required(),
			amis()->TextControl('depos_address', '仓库地址')->required(),
			amis()->NumberControl('depos_sort', '排序[0-255]')->value(10)->required(),
			amis()->SwitchControl('depos_status', '状态')->onText('启用')->offText('停用'),
			amis()->TextControl('depos_keeper', '仓管员'),
			amis()->NumberControl('depos_tel', '联系电话')->required(),
        ]);
    }

    public function detail(): Form
    {
        return $this->baseDetail()->columnCount(2)->body([
            amis()->TextControl('id', 'ID')->static(),
			amis()->TextControl('depos_name', '仓库名称')->static(),
			amis()->TextControl('depos_volume_', '仓库容积')->value('${depos_volume} M³')->static(),
			amis()->TextControl('depos_square_', '仓库面积')->value('${depos_square} M²')->static(),
			amis()->ImageControl('depos_images_url', '仓库图片')->disabled(),
			amis()->InputCityControl('depos_area', '地区id')->static(),
			amis()->TextControl('depos_address', '仓库地址')->static(),
			amis()->TextControl('depos_sort', '排序[0-255]')->static(),
			amis()->SwitchControl('depos_status', '状态')->onText('启用')->offText('停用')->disabled(),
			amis()->TextControl('depos_keeper', '仓管员')->static(),
			amis()->TextControl('depos_tel', '联系电话')->static(),
			amis()->TextControl('created_at', __('admin.created_at'))->static(),
			amis()->TextControl('updated_at', __('admin.updated_at'))->static()
        ]);
    }
}
