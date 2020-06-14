<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCustomerServicesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('customer_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('customer_account_no');
            $table->enum('status', ['ACTIVE', 'DE-ACTIVE']);
            $table->text('plan');
            $table->text('sac_code');
            $table->decimal('amount', 10, 2);
            $table->string('frequency');
            $table->date('start_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->decimal('sgst', 10, 2)->default('00.00');
            $table->decimal('cgst', 10, 2)->default('00.00');
            $table->decimal('igst', 10, 2)->default('00.00');
            $table->decimal('taxable', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('customer_account_no')->references('account_no')->on('customer_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('customer_services');
    }
}
