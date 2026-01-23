<?php

namespace Daga\Erp\Http\Controllers;

use Dagasmart\BizAdmin\Renderers\Page;
use Dagasmart\BizAdmin\Renderers\Form;
use Dagasmart\BizAdmin\Controllers\AdminController;
use Daga\Erp\Services\ErpBasicProductCateService;

/**
 * 产品分类表
 *
 * @property ErpBasicProductCateService $service
 */
class ErpBasicProductCateController extends AdminController
{
    protected string $serviceName = ErpBasicProductCateService::class;

    public function list(): Page
    {
        $crud = $this->baseCRUD()
            ->filterTogglable(false)
			->headerToolbar([
				$this->createButton(true, 'sm'),
				...$this->baseHeaderToolBar()
			])
            ->autoFillHeight(true)
            ->columns([
                amis()->TableColumn('id', 'ID')->sortable(),
				amis()->TableColumn('cate_name', '分类名称')
                    ->searchable(),
				amis()->TableColumn('parent_id', '父级id')
                    ->searchable([
                        'type'=>'tree-select',
                        'name'=>'parent_id',
                        'searchable'=>true,
                        'options'=>$this->service->treeOptions()
                    ])
                    //->quickEdit([
                    //    'type'=>'tree-select',
                    //    'name'=>'parent_id',
                    //    'searchable'=>true,
                    //    'source'=>admin_url('daga/erp/basic/product/tree/options?id=${id}')
                    //])
                    ->set('type','tree-select')
                    ->set('options',$this->service->treeOptions())
                    ->set('static',true),

				amis()->TableColumn('cate_short', '简称'),
				amis()->TableColumn('sort', '排序[0-255]')->quickEdit(['type'=>'input-number','min'=>0]),
				amis()->TableColumn('updated_at', __('admin.updated_at'))->set('type', 'datetime')->sortable(),
                $this->rowActions(true, 'sm')
            ]);

        return $this->baseList($crud);
    }

    public function form($isEdit = false): Form
    {
        return $this->baseForm()->body([
            amis()->TextControl('cate_name', '分类名称${id}')->required(),
			amis()->TreeSelectControl('parent_id', '父级id')
                //->options($this->service->treeOptions())
                ->source(admin_url('daga/erp/basic/product/tree/options?id=${id}'))
                ->searchable(),
			amis()->TextControl('cate_short', '简称'),
			amis()->NumberControl('sort', '排序[0-255]')
                ->value(10)
                ->required(),
        ]);
    }

    public function detail(): Form
    {
        return $this->baseDetail()->body([
            amis()->TextControl('id', 'ID')->static(),
			amis()->TextControl('cate_name', '分类名称')->static(),
			amis()->TreeSelectControl('parent_id', '父级id')
                ->options($this->service->treeOptions())
                ->static(),
			amis()->TextControl('cate_short', '简称')->static(),
			amis()->NumberControl('sort', '排序[0-255]')->static(),
			amis()->TextControl('updated_at', __('admin.updated_at'))->static()
        ]);
    }

    public function treeOptions(): array
    {
        return $this->service->treeOptions();
    }

}
