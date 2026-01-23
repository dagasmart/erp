<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const table = 'erp_basic_supplier';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->rename();
        Schema::create(self::table, function (Blueprint $table) {
            $table->comment('供货商表');
            $table->increments('id');
            $table->string('sup_name')->comment('供货商');
            $table->string('sup_company')->nullable()->comment('公司名称');
            $table->string('sup_legal')->nullable()->comment('负责人');
            $table->string('sup_scope')->nullable()->comment('经营范围');
            $table->string('sup_man')->nullable()->comment('联系人');
            $table->string('sup_phone')->nullable()->comment('联系电话');
            $table->string('sup_email')->nullable()->comment('电子邮箱');
            $table->string('sup_qq')->nullable()->comment('qq号码');
            $table->string('sup_zip_code')->nullable()->comment('邮政编码');
            $table->bigInteger('sup_area')->nullable()->comment('地区id');
            $table->string('sup_address')->nullable()->comment('公司地址');
            $table->unsignedFloat('sup_current_pay')->default(0)->comment('当前应付款');
            $table->unsignedFloat('sup_init_pay')->default(0)->comment('初始应付款');
            $table->string('sup_desc')->nullable()->comment('备注');
            $table->unsignedInteger('mer_id')->nullable()->default(0)->comment('商户id');
            $table->string('mer_name')->nullable()->comment('商户名');
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
