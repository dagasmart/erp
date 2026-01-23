<?php

namespace Daga\Erp\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Dagasmart\BizAdmin\Models\BaseModel as Model;

/**
 * 客户表
 */
class ErpBasicCrm extends Model
{
    use SoftDeletes;
    protected $table = 'erp_basic_crm';

    protected $primaryKey = 'id';

    //隐藏的字段
    protected $hidden = ['mer_id'];

    /**
     * 客户等级
     * @param $id
     * @return mixed
     */
    public function level($id = null): mixed
    {
        if(!is_null($id)){
            $items = array_column(basic_dict()->getOptions('system.basic.level'),'label','value');
            return $items[$id];
        }
        return basic_dict()->getOptions('system.basic.level');
    }

}
