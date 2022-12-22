<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingConfirmationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_confirmations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('book_appointment_id')->comment('Тут должна быть связь, но создать её не получилось. Миграции не создавались, на поиск проблемы времени нет, таблица просто не находится.');
            $table->boolean('mentor_confirmation')->nullable();
            $table->boolean('customer_confirmation')->nullable();
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
        Schema::dropIfExists('meeting_confirmations');
    }
}
