<?php

namespace Daga\Erp\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dagasmart\BizAdmin\Models\AdminUser;
use Dagasmart\BizAdmin\Models\BaseModel as Model;

/**
 * 供货商表
 */
class ErpBasicSupplier extends Model
{
    use SoftDeletes;

    protected $table = 'erp_basic_supplier';

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(AdminUser::class, 'admin_role_permissions', 'role_id', 'permission_id')
            ->withTimestamps();
    }

}
