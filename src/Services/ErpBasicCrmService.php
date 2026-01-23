<?php
namespace Daga\Erp\Services;

use Daga\Erp\Models\ErpBasicCrm;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Dagasmart\BizAdmin\Services\AdminService;

/**
 * 客户表
 *
 * @method ErpBasicCrm getModel()
 * @method ErpBasicCrm|\Illuminate\Database\Query\Builder query()
 */
class ErpBasicCrmService extends AdminService
{
    protected string $modelName = ErpBasicCrm::class;

    public function list(): LengthAwarePaginator|array
    {
        if($crm_state = $this->request['crm_state']){
            unset($this->request['crm_state']);
        }
        if($crm_level = $this->request['crm_level']){
            unset($this->request['crm_level']);
        }
        return $this->listQuery()
            ->when(!is_null($crm_state), function ($query)use($crm_state){
                $query->where('crm_state', $crm_state);
            })
            ->when(!is_null($crm_level), function ($query)use($crm_level){
                $query->whereIn('crm_level', explode(',', $crm_level));
            })
            ->paginate(request('perPage', 20));
    }

    public function level()
    {
        return $this->getModel()->level();
    }

}
