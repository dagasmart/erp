<?php

namespace Daga\Erp\Services;

use Daga\Erp\Models\ErpBasicProductUnit;
use Dagasmart\BizAdmin\Services\AdminService;

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
