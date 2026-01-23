<?php

namespace Daga\Erp\Models;

use App\Libs\Common;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dagasmart\BizAdmin\Models\BaseModel as Model;

/**
 * 采购订单表
 */
class ErpPurchaseOrder extends Model
{
    use Common, SoftDeletes;

    protected $table = 'erp_purchase_order';

    protected $primaryKey = 'id';

}
