<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Checkin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->integer('assets_id')->comment("realasi ke table assets");
            $table->string('document_type', 255);
            $table->string('registration_number', 255);
            $table->date('registration_date');
            $table->string('expense_number', 255);
            $table->date('dispensing_date');
            $table->string('name_sender', 255);
            $table->string('item_code', 255);
            $table->string('item_category', 255);
            $table->string('item_name', 255);
            $table->string('item_unit', 255);
            $table->integer('item_quantity');
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
        //
        Schema::dropIfExists('checkins');
    }
}
