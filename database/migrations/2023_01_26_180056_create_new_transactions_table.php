<?php

use App\Models\BookAppointment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::disableForeignKeyConstraints();
        Schema::create('new_transactions', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->foreignId('payer_id')->nullable()->constrained('users')->restrictOnDelete();
            $table->foreignId('recipient_id')->nullable()->constrained('users')->restrictOnDelete();
            $table->decimal('amount');
            $table->decimal('customer_amount')->nullable();
            $table->enum('type', ['payment', 'withdraw']);
            $table->enum('status', ['processing', 'holding', 'done', 'refused', 'returning', 'returned']);
            $table->json('payment_object')->nullable();
            $table->unsignedBigInteger('operation_id')->nullable();
            $table->foreignIdFor(BookAppointment::class)->nullable()->constrained()->nullOnDelete();
            $table->text('comment')->nullable();
            $table->text('public_comment')->nullable();
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
        Schema::dropIfExists('new_transactions');
    }
}
