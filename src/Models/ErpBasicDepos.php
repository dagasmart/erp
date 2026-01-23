<?php

namespace Daga\Erp\Models;

use App\Libs\Common;
use Dagasmart\BizAdmin\Models\BaseModel as Model;

/**
 * 仓库表
 */
class ErpBasicDepos extends Model
{
    use Common;
    protected $table = 'erp_basic_depos';

    protected $primaryKey = 'id';

    protected $appends = ['depos_images_url'];

    /**
     * 图片url
     * @return string|null
     */
    public function getDeposImagesUrlAttribute(): ?string
    {
        return $this->ImageUrl($this->depos_images);
    }

    /**
     * 图片相对路径
     * @param $value
     * @return void
     */
    public function setDeposImagesAttribute($value): void
    {
        $this->attributes['depos_images'] = $this->ImagePath($value);
    }

}
