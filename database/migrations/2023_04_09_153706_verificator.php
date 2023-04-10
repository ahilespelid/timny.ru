<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Verificator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verificator', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable()->default(NULL);
            $table->string('email')->nullable()->default(NULL);
            $table->tinyInteger('status')->default('2');
            ///*/ $table->timestamp('read_at')->nullable(); ///*/
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
        Schema::dropIfExists('verificator');
    }
}
