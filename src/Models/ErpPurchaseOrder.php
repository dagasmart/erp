<?php

namespace DagaSmart\Erp\Models;

use App\Libs\Common;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 采购订单表
 */
class ErpPurchaseOrder extends Model
{
    use Common, SoftDeletes;

    protected $table = 'erp_purchase_order';

    protected $primaryKey = 'id';

}
