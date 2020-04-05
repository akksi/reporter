<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpworkTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upwork_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->date('date');
            $table->unsignedInteger('reference_id');
            $table->string('type');
            $table->text('description');
            $table->string('agency')->nullable();
            $table->string('freelancer')->nullable();
            $table->string('team')->nullable();
            $table->string('account_name');
            $table->string('po')->nullable();
            $table->decimal('amount', 8, 2);
            $table->decimal('amount_in_local_currency', 10, 2)->nullable();
            $table->char('currency', 3)->nullable();
            $table->decimal('balance', 10, 2)->nullable();
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
        Schema::dropIfExists('upwork_transactions');
    }
}
