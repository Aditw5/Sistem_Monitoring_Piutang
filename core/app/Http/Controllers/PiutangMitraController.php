<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PiutangMitra;
use App\Helpers\Lyn;
use App\Models\Mitra;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Campaigns;
use App\Models\Contact;
use App\Models\ContactLabel;
use App\Models\Session;
use App\Models\AutoResponder;
use App\Models\Bulk;

class PiutangMitraController extends Controller
{
    public function piutang(Request $request)
    {
        if ($request->ajax() || $request->isMethod('POST')) {
            // Query to fetch data from the database, excluding rows with "Sudah Bayar" and "Tervalidasi" status
            $table = PiutangMitra::with('mitra')
                ->where('status', '!=', 'Sudah Bayar')
                ->get();

            $table->transform(function ($item) {
                $item->tgl_mulai_piutang = Carbon::parse($item->tgl_mulai_piutang)->locale('id')->isoFormat('LL');
                $item->tgl_jatuh_tempo = Carbon::parse($item->tgl_jatuh_tempo)->locale('id')->isoFormat('LL');

                return $item;
            });

            return datatables()->of($table)->addIndexColumn()
                ->addColumn('responsive_id', function () {
                    return '';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-icon btn-label-primary me-1 is-btn-piutang-edit" data-id="' . $row->id . '"><span class="ti ti-edit"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $mitras = Mitra::all();
        return Lyn::view('piutang.piutang', compact('mitras'));
    }

    public function piutang_store(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
        }

        $request->validate([
            'mitra_id' => 'required',
            'item' => ['required', 'numeric'],
            'besar_uang' => 'required',
            'jenis_layanan' => 'required',
            'status' => 'required',
            'tgl_mulai_piutang' => 'required',
            'tgl_jatuh_tempo' => 'required',
        ]);

        // Cek apakah data sudah ada sebelumnya
        $existingPiutang = PiutangMitra::where('mitra_id', $request->mitra_id)
            ->where('item', $request->item)
            ->where('besar_uang', str_replace('.', '', $request->besar_uang))
            ->where('jenis_layanan', $request->jenis_layanan)
            ->where('status', $request->status)
            ->where('tgl_mulai_piutang', $request->tgl_mulai_piutang)
            ->where('tgl_jatuh_tempo', $request->tgl_jatuh_tempo)
            ->first();

        if ($existingPiutang) {
            return response()->json(['status' => 'error', 'message' => 'Data already exists'], 400);
        }

        $piutang = new PiutangMitra();
        $piutang->mitra_id = $request->mitra_id;
        $piutang->item = $request->item;
        $piutang->besar_uang = str_replace('.', '', $request->besar_uang);
        $piutang->jenis_layanan = $request->jenis_layanan;
        $piutang->status = $request->status;

        // Periksa apakah status_validasi disertakan dalam request
        // Jika tidak, gunakan nilai bawaan enum database
        if ($request->has('status_validasi')) {
            $piutang->status_validasi = $request->status_validasi;
        }

        $piutang->tgl_mulai_piutang = $request->tgl_mulai_piutang;
        $piutang->tgl_jatuh_tempo = $request->tgl_jatuh_tempo;
        $piutang->save();

        return response()->json(['status' => 'success', 'message' => 'Mitra created successfully'], 200);
    }

    public function piutang_update(Request $request)
    {
        // Periksa apakah permintaan merupakan permintaan ajax
        if (!$request->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Invalid request.'], 400);
        }

        // Validasi data permintaan
        $request->validate([
            'id' => 'required',
        ]);

        try {
            // Temukan record piutang mitra berdasarkan ID yang diberikan dalam permintaan
            $piutang_mitra = PiutangMitra::findOrFail($request->id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Piutang mitra not found.'], 404);
        }

        // Perbarui data status dan status validasi piutang mitra dengan data dari permintaan
        if ($request->has('status')) {
            $piutang_mitra->status = $request->status;
        }
        if ($request->has('status_validasi')) {
            $piutang_mitra->status_validasi = $request->status_validasi;
        }

        // Simpan record piutang mitra
        $piutang_mitra->save();

        // Mengembalikan pesan keberhasilan
        return response()->json(['status' => 'success', 'message' => 'Piutang mitra berhasil diperbarui.'], 200);
    }

    public function piutang_edit(Request $request, $id)
    {
        if (!$request->ajax()) return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
        $piutang_mitra = PiutangMitra::find($id);
        if (!$piutang_mitra) return response()->json(['status' => 'error', 'message' => 'Piutang mitra not found'], 404);

        // Ubah format tanggal menjadi format tanggal Indonesia
        $piutang_mitra->tgl_mulai_piutang = Carbon::parse($piutang_mitra->tgl_mulai_piutang)->locale('id')->isoFormat('LL');
        $piutang_mitra->tgl_jatuh_tempo = Carbon::parse($piutang_mitra->tgl_jatuh_tempo)->locale('id')->isoFormat('LL');

        return response()->json([
            'status' => 'success',
            'data' => $piutang_mitra
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
