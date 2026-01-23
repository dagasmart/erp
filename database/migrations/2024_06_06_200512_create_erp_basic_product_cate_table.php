<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('erp_basic_product_cate')) {
            Schema::rename('erp_basic_product_cate', 'backup_erp_basic_product_cate_'.date('YmdHis'));
        }
        Schema::create('erp_basic_product_cate', function (Blueprint $table) {
            $table->comment('产品分类表');
            $table->increments('id');
            $table->string('cate_name')->nullable()->comment('分类名称');
            $table->integer('parent_id')->default('0')->comment('父级id');
            $table->string('cate_short')->nullable()->comment('简称');
            $table->integer('sort')->default('10')->comment('排序[0-255]');
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
        if (Schema::hasTable('erp_basic_product_cate')) {
            Schema::rename('erp_basic_product_cate', 'backup_erp_basic_product_cate_'.date('YmdHis'));
        }
        Schema::dropIfExists('erp_basic_product_cate');
    }
};
