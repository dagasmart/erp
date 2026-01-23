<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const table = 'erp_basic_product';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->rename();
        Schema::create(self::table, function (Blueprint $table) {
            $table->comment('基础产品档案表');
            $table->increments('id');
            $table->string('name')->nullable()->comment('产品名称');
            $table->string('py_code')->nullable()->comment('拼音码');
            $table->string('item_no')->nullable()->comment('产品编号');
            $table->bigInteger('sup_id')->default(0)->comment('供货商');
            $table->unsignedInteger('type')->nullable()->comment('类型');
            $table->unsignedInteger('unit_id')->nullable()->comment('单位');
            $table->bigInteger('mer_id')->default(0)->comment('商户id');
            $table->string('module',50)->nullable()->comment('模块');
            $table->timestamps();
            $table->softDeletes();
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
