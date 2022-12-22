<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingConflictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_conflicts', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_autocreated')->default(0);
            $table->bigInteger('book_appointment_id')->comment('Тут должна быть связь, но создать её не получилось. Миграции не создавались, на поиск проблемы времени нет, таблица просто не находится.');$table->boolean('is_autocreated')->default(false);
            $table->json('conflict_log')->nullable();
            $table->enum('status', ['created', 'processing', 'done'])->default('created');
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
        Schema::dropIfExists('meeting_conflicts');
    }
}
