<?php

namespace DagaSmart\Erp\Models;

use DagaSmart\BizAdmin\Models\BaseModel;

/**
 *基座模型
 */
class Model extends BaseModel
{

    const string schema = 'school'; //连接的数据库名

    protected $connection = self::schema; // 使用school数据库连接

    public function __construct()
    {
        if (!isset($this->connection)) {
            $this->setConnection($this->connection);
        }
        parent::__construct();
    }

    protected static function booted(): void
    {
        parent::booted();
    }

}
