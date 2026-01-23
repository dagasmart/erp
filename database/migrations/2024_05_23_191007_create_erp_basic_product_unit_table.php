<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const table = 'erp_basic_product_unit';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->rename();
        Schema::create(self::table, function (Blueprint $table) {
            $table->comment('基础产品单位表');
            $table->increments('id');
            $table->string('name')->nullable()->comment('名称');
            $table->integer('sort')->comment('排序[0-255]');
            $table->integer('mer_id')->default('0')->comment('商户id');
            $table->string('module',50)->nullable()->comment('模块');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->rename();
        Schema::dropIfExists(self::table);
    }

    /**
     * rename the old migrations.
     * @return void
     */
    private function rename(): void
    {
        if (Schema::hasTable(self::table)) {
            //备份已存在表
            Schema::rename(self::table, 'backup_' . self::table . '_' .date('YmdHis'));
        }
    }


};
