<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustments', function (Blueprint $table) {
            $table->id();
            $table->integer('assets_id')->comment("realasi ke table assets");
            $table->date('implementation_date');
            $table->string('item_code', 255);
            $table->string('item_category', 255);
            $table->string('item_name', 255);
            $table->string('item_unit', 255);
            $table->integer('item_quantity');
            $table->double('starting_balance');
            $table->integer('total_income');
            $table->integer('total_expense');
            $table->string('adjusment', 255);
            $table->double('final_balance');
            $table->string('enumeration_result', 255);
            $table->integer('total_difference');
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
        Schema::dropIfExists('adjustments');
    }
}
