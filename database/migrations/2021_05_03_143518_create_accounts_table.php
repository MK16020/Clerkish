<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('accountCode');
            $table->string('name');
            $table->enum('type', ['PAYABLE', 'RECEIVABLE', ' ']);
            $table->boolean('locked')->default(false);
            $table->boolean('main');
            $table->foreignId('parentID')->nullable();
            $table->nextChildCode('lastChildID')->nullable();
            $table->softDeletes();
            $table->timestamps();

            Schema::table('accounts', function (Blueprint $table) {
                $table->foreign('parentID')
                ->references('id')->on('accounts')
                ->onDelete('cascade');
            });
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
