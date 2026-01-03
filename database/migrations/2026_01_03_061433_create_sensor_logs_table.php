<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('sensor_logs', function (Blueprint $table) {
        $table->id(); // ID unik otomatis

        // Sensor TDS (Salinitas) - pakai float untuk angka desimal
        $table->float('tds_value');

        // Sensor Ketinggian Air (cm) - pakai float
        $table->float('water_level');

        // Sensor Pintu (Open/Close) - pakai string (teks pendek)
        $table->string('door_status');

        // Ini otomatis membuat kolom 'created_at' (waktu masuk)
        // dan 'updated_at'
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_logs');
    }
};
