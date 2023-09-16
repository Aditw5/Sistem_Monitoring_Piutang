<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Lyn;
use App\Models\PiutangMitra;
use App\Models\Mitra;

class HalamanController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function dashboard()
    {
        $piutangs = PiutangMitra::all();
        $mitras = Mitra::all();

        // Menghitung total mitra
        $totalMitra = $mitras->count();
        $totalPiutang = $piutangs->count();

        // Menghitung total piutang yang belum divalidasi
        $totalPiutangBelumValidasi = PiutangMitra::where('status_validasi', '')->count();

        return Lyn::view('dashboard.dashboard', compact('piutangs', 'totalMitra', 'totalPiutang', 'totalPiutangBelumValidasi'));
    }
}
