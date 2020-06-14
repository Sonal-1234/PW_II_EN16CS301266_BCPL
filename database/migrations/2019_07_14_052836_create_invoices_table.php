<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->string('po_number');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('customer_account_no');
            $table->enum('status', ['PAID', 'UNPAID'])->default('UNPAID');
            $table->date('due_date')->nullable();
            $table->date('order_date');
            $table->integer('number_of_item');
            $table->decimal('total', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('taxable', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default('00.00');
            $table->decimal('due_amount', 10, 2)->default('00.00');
            $table->timestamp('paid_at')->nullable();
            $table->enum('invoice_generate', ['Yes', 'No'])->default('No');
            $table->text('payment_remarks')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('customer_account_no')->references('account_no')->on('customer_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('invoices');
    }
}
