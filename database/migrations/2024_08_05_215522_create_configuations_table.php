<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuations', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['PAYMENT_DATE', 'APP_NAME', 'DEVELOPPER_NAME', 'ANOTHER'])->default('ANOTHER')->comment('table de configuration');
            $table->timestamps();
            $table->string('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuations');
    }
};
