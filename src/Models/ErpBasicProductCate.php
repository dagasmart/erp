<?php

namespace Daga\Erp\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Dagasmart\BizAdmin\Models\BaseModel as Model;

/**
 * 产品分类表
 */
class ErpBasicProductCate extends Model
{
    use SoftDeletes;

    protected $table = 'erp_basic_product_cate';

    protected $primaryKey = 'id';

}
