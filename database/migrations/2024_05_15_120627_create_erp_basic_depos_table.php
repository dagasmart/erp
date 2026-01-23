<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const table = 'erp_basic_depos';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->rename();
        Schema::create(self::table, function (Blueprint $table) {
            $table->comment('仓库表');
            $table->increments('id');
            $table->string('depos_name')->nullable()->comment('仓库名称');
            $table->integer('depos_volume')->nullable()->default('0')->comment('仓库容积');
            $table->integer('depos_square')->nullable()->default('0')->comment('仓库面积');
            $table->text('depos_images')->nullable()->comment('仓库图片');
            $table->string('depos_location')->nullable()->comment('位置定位');
            $table->bigInteger('depos_area')->nullable()->comment('地区ID');
            $table->string('depos_address')->nullable()->comment('仓库地址');
            $table->integer('depos_sort')->nullable()->comment('排序[0-255]');
            $table->integer('depos_status')->default('1')->comment('状态：0关闭，1开启');
            $table->string('depos_keeper')->nullable()->comment('仓管员');
            $table->string('depos_tel')->nullable()->comment('联系电话');
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
