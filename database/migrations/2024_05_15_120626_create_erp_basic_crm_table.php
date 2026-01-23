<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const table = 'erp_basic_crm';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->rename();
        Schema::create(self::table, function (Blueprint $table) {
            $table->comment('客户表');
            $table->increments('id');
            $table->string('crm_name')->nullable()->comment('姓名');
            $table->integer('crm_type')->default(3)->nullable()->comment('类型：1本地客户，2线上会员');
            $table->integer('crm_sex')->default(3)->nullable()->comment('性别：1男，2女，3保密');
            $table->string('crm_tel')->nullable()->comment('联系电话');
            $table->integer('crm_area')->nullable()->comment('地区ID');
            $table->string('crm_address')->nullable()->comment('常住地址');
            $table->string('crm_email')->nullable()->comment('电子邮箱');
            $table->integer('crm_level')->default(1)->nullable()->comment('等级：1普通，2VIP');
            $table->decimal('crm_consume')->default('0.00')->nullable()->comment('消费总金额');
            $table->integer('crm_point')->nullable()->comment('获取积分');
            $table->integer('crm_state')->default(1)->nullable()->comment('状态：0关闭，1开启');
            $table->string('crm_recode')->nullable()->comment('推荐码');
            $table->integer('mer_id')->default(0)->nullable()->comment('商户id');
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
