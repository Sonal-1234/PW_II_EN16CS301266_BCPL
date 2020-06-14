<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAccountsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('customer_accounts', function (Blueprint $table) {
            $table->bigIncrements('account_no')->index();
            $table->unsignedBigInteger('customer_id');
            $table->enum('status', ['ACTIVE', 'DE-ACTIVE'])->default('DE-ACTIVE');
            $table->tinyInteger('due_invoice_reminder')->default(0);
            $table->tinyInteger('invoice_reminder')->default(0);
            $table->longText('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('customer_accounts');
    }
}
