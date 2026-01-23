<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const table = 'erp_purchase_order';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->rename();
        Schema::create('erp_purchase_order', function (Blueprint $table) {
            $table->comment('采购订单表');
            $table->increments('id');
            $table->string('order_no')->nullable()->comment('订单单号');
            $table->tinyInteger('sup_id')->nullable()->default(0)->comment('供应商id');
            $table->tinyInteger('state')->nullable()->comment('状态');
            $table->string('other')->nullable()->comment('备注');
            $table->tinyInteger('check_status')->nullable()->comment('核实状态');
            $table->unsignedInteger('user_id')->default('0')->comment('创建人id');
            $table->string('user_as')->nullable()->comment('创建人');
            $table->tinyInteger('audit_status')->nullable()->comment('审核状态');
            $table->string('finished_at')->default('')->comment('订单完成时间');
            $table->integer('mer_id')->default('0')->comment('商户id');
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
    public function down()
    {
        $this->rename();
        Schema::dropIfExists('erp_purchase_order');
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
