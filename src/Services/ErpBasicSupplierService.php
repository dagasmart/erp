<?php

namespace Daga\Erp\Services;

use Daga\Erp\Models\ErpBasicSupplier;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Dagasmart\BizAdmin\Services\AdminService;

/**
 * 供货商表
 *
 * @method ErpBasicSupplier getModel()
 * @method ErpBasicSupplier|\Illuminate\Database\Query\Builder query()
 */
class ErpBasicSupplierService extends AdminService
{
    protected string $modelName = ErpBasicSupplier::class;

    /**
     * 供货商列表
     * @param string $column
     * @param string $key
     * @return array
     */
    public static function pluck(string $column, string $key): array
    {
        return ErpBasicSupplier::query()
            ->when(admin_user()->mer_id, function ($query){
                $query->where('mer_id', admin_user()->mer_id);
            })
            ->when(current_module(), function ($query){
                $query->where('module', current_module());
            })
            ->pluck($column, $key)->toArray();
    }

    /**
     * 供货商名称
     * @param int $id
     * @return string|null
     */
    public static function sup_as(int $id): string|null
    {
        return ErpBasicSupplier::query()->where('id',$id)->value('sup_name');
    }


}
