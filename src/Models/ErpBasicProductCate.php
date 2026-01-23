<?php

namespace DagaSmart\Erp\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 产品分类表
 */
class ErpBasicProductCate extends Model
{
    use SoftDeletes;

    protected $table = 'erp_basic_product_cate';

    protected $primaryKey = 'id';

}
