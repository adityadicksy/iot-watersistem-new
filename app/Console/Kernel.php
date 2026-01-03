<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\SensorLog; // <--- PENTING: Panggil Model Sensor

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // --- ROBOT KEBERSIHAN KITA MASUK DI SINI ---

        $schedule->call(function () {
            // 1. Tentukan batas waktu (24 jam lalu)
            $batasWaktu = now()->subHours(24);

            // 2. Hapus data lama
            SensorLog::where('created_at', '<', $batasWaktu)->delete();

        })->hourly(); // Jalankan tiap jam
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
