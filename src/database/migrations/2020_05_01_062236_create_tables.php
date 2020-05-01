<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Routing\Matching\SchemeValidator;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Block\Parser\BlockQuoteParser;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('fm_category', function(Blueprint $table){
           $table->uuid('id', 36)->primary();
           $table->string('title')->nullable(false)->unique();
           $table->string('url')->default('#');
           $table->Integer('serial')->unsigned()->default(0);
           $table->timestamp('create_at')->useCurrent();
           $table->timestamp('update_at')->useCurrent();
       });
       
       Schema::create('fm_data', function(Blueprint $table){
           $table->uuid('id', 36)->primary();
           $table->string('title')->nullable(false)->unique();
           $table->string('url')->nullable();
           $table->Integer('count')->unsigned()->nullable(false)->default(0);
           $table->uuid('category_id')->nullable(false);
           $table->timestamp('create_at')->useCurrent();
           $table->timestamp('update_at')->useCurrent();

           $table->foreign('category_id')->references('id')->on('fm_category');
       });

       Schema::create('fm_tag', function(Blueprint $table){
           $table->uuid('id', 36)->primary();
           $table->string('name')->nullable(false)->unique();
           $table->Integer('serial')->unsigned()->default();
           $table->timestamp('create_at')->useCurrent();
           $table->timestamp('update_at')->useCurrent();
       });

       Schema::create('fm_tag_data', function(Blueprint $table){
           $table->uuid('tag_id', 36);
           $table->uuid('data_id', 36);

           $table->primary(['tag_id','data_id']);
           $table->foreign('tag_id')->references('id')->on('fm_tag');
           $table->foreign('data_id')->references('id')->on('fm_data');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('fm_tag_data');
        Schema::dropIfExists('fm_data');
        Schema::dropIfExists('fm_tag');
        Schema::dropIfExists('fm_category');
    }
}
