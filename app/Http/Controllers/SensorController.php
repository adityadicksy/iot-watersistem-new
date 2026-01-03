<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorLog; // Memanggil Model Database

class SensorController extends Controller
{
    // --- 1. Fungsi untuk SIM900 (Menerima Data) ---
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'tds_value' => 'required',
            'water_level' => 'required',
            'door_status' => 'required',
        ]);

        // Simpan ke database
        SensorLog::create([
            'tds_value' => $request->tds_value,
            'water_level' => $request->water_level,
            'door_status' => $request->door_status,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data tersimpan'], 200);
    }

    // --- 2. Fungsi untuk Menampilkan Halaman Website ---
    public function index()
    {
        // Memanggil file tampilan bernama 'monitoring.blade.php'
        return view('monitoring');
    }

    // --- 3. Fungsi untuk Website Mengambil Data Terbaru (AJAX) ---
    public function getLatest()
    {
        // Ambil 1 data paling baru berdasarkan waktu input
        $data = SensorLog::latest()->first();

        // Kirim datanya dalam bentuk JSON ke Javascript
        return response()->json($data);
    }
}
