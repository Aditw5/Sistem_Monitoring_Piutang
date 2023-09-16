<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Lyn;
use App\Models\PiutangMitra;
use App\Models\Mitra;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function laporan(Request $request)
    {
        if ($request->ajax() || $request->isMethod('POST')) {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
    
            $query = PiutangMitra::with('mitra');
    
            if ($fromDate && $toDate) {
                $query->whereBetween('tgl_mulai_piutang', [$fromDate, $toDate]);
            }
    
            $table = $query->get();
    
            $totalBesarUang = $table->sum('besar_uang');
            $totalItem = $table->count();
    
            $table->transform(function ($item) {
                $item->tgl_mulai_piutang = Carbon::parse($item->tgl_mulai_piutang)->locale('id')->isoFormat('LL');
                $item->tgl_jatuh_tempo = Carbon::parse($item->tgl_jatuh_tempo)->locale('id')->isoFormat('LL');
    
                return $item;
            });
    
            return datatables()->of($table)->addIndexColumn()
                ->addColumn('responsive_id', function () {
                    return '';
                })
                ->addColumn('mitra_id', function ($row) {
                    return $row->mitra->name;
                })
                ->addColumn('no_kontrak', function ($row) {
                    return $row->mitra->no_kontrak;
                })
                ->addColumn('nomor_hp', function ($row) {
                    return $row->mitra->nomor_hp;
                })
                ->addColumn('item', function ($row) {
                    return $row->item;
                })
                ->addColumn('besar_uang', function ($row) {
                    return $row->besar_uang;
                })
                ->addColumn('jenis_layanan', function ($row) {
                    return $row->jenis_layanan;
                })
                ->addColumn('status', function ($row) {
                    return $row->status;
                })
                ->addColumn('tgl_mulai_piutang', function ($row) {
                    return $row->tgl_mulai_piutang;
                })
                ->addColumn('tgl_jatuh_tempo', function ($row) {
                    return $row->tgl_jatuh_tempo;
                })
                ->rawColumns(['responsive_id'])
                ->make(true);
        }
    
        $mitras = Mitra::all();
        return Lyn::view('laporan.laporan', compact('mitras'));
    }

    // ...
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
