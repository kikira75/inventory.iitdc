<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOpnamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_opnames', function (Blueprint $table) {
            $table->id();
            $table->integer('assets_id')->comment("realasi ke table assets");
            $table->date('implementation_date');
            $table->string('item_code', 255);
            $table->string('item_category', 255);
            $table->string('item_name', 255);
            $table->string('item_unit', 255);
            $table->integer('item_quantity');
            $table->string('description', 255);
            $table->enum('entry_status', ['l', 'tl'])->comment("l->lengkap, tl->tidak lengkap");
            $table->enum('status_sending', ['a', 'n'])->comment("a->active, n->nonactive");
            $table->dateTime('datetime_sending', precision: 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_opnames');
    }
}
