<?php

namespace DagaSmart\Erp\Services;

use DagaSmart\Erp\Models\ErpBasicProductUnit;

/**
 * 基础产品单位表
 *
 * @method ErpBasicProductUnit getModel()
 * @method ErpBasicProductUnit|\Illuminate\Database\Query\Builder query()
 */
class ErpBasicProductUnitService extends AdminService
{
    protected string $modelName = ErpBasicProductUnit::class;
}
