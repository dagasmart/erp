<?php

namespace Daga\Erp\Models;

use App\Libs\Common;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dagasmart\BizAdmin\Models\BaseModel as Model;

/**
 * 产品档案表
 */
class ErpBasicProduct extends Model
{
    use Common, SoftDeletes;

    protected $table = 'erp_basic_product';

    protected $primaryKey = 'id';

    protected $appends = ['image_url','slider_image_url'];


    const TYPE_PACK = 1;
    const TYPE_BULK = 0;

    const TYPE = [self::TYPE_PACK => '包装', self::TYPE_BULK => '散装'];

    public function setPyCodeAttribute(): ?string
    {
        return $this->attributes['py_code'] = $this->upper_pinyin_abbr($this->attributes['name']);
    }

    /**
     * 图片url
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->ImageUrl($this->image);
    }

    /**
     * 组图url

     */
    public function getSliderImageUrlAttribute(): bool|string|null
    {
        return $this->ImageFormat($this->slider_image,1);
    }

    /**
     * 图片相对路径
     * @param $value
     * @return void
     */
    public function setImageAttribute($value): void
    {
        $this->attributes['image'] = $this->ImagePath($value);
    }

    /**
     * 多图片相对路径
     * @param $value
     * @return void
     */
    public function setSliderImageAttribute($value): void
    {
        $this->attributes['slider_image'] = $this->ImageFormat($value);
    }




}
