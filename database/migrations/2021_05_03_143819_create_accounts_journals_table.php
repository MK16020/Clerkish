<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts_journals', function (Blueprint $table) {
            $table->unsignedBigInteger('accountID');
            $table->unsignedBigInteger('journalID');
            $table->double('debit', 8, 2);
            $table->double('credit', 8, 2);
            $table->text('statment')->nullable();

            $table->primary(['accountID', 'journalID']);

            $table->foreign('accountID')
                ->references('id')->on('accounts')
                ->onDelete('cascade');

            $table->foreign('journalID')
                ->references('id')->on('daily_journals')
                ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_journals');
    }
}
