<?php

namespace Daga\Erp\Http\Controllers;

use Dagasmart\BizAdmin\Renderers\Page;
use Dagasmart\BizAdmin\Renderers\Form;
use Dagasmart\BizAdmin\Controllers\AdminController;
use Daga\Erp\Services\ErpBasicProductUnitService;

/**
 * 基础产品单位表
 *
 * @property ErpBasicProductUnitService $service
 */
class ErpBasicProductUnitController extends AdminController
{
    protected string $serviceName = ErpBasicProductUnitService::class;

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
				amis()->TableColumn('name', '名称')->sortable(),
				amis()->TableColumn('sort', '排序[0-255]')->sortable(),
                $this->rowActions(true, 'sm')
            ]);

        return $this->baseList($crud);
    }

    public function form($isEdit = false): Form
    {
        return $this->baseForm()->body([
            amis()->TextControl('name', '名称')->required(),
			amis()->NumberControl('sort', '排序[0-255]')
                ->value(10)
                ->min(0)
                ->required(),
        ]);
    }

    public function detail(): Form
    {
        return $this->baseDetail()->body([
            amis()->TextControl('id', 'ID')->static(),
			amis()->TextControl('name', '名称')->static(),
			amis()->TextControl('sort', '排序[0-255]')->static()
        ]);
    }
}
