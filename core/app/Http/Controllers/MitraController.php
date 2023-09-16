<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Helpers\Lyn;
use Illuminate\Support\Facades\Storage;
use App\Models\Campaigns;
use App\Models\Contact;
use App\Models\ContactLabel;
use App\Models\Session;
use App\Models\AutoResponder;
use App\Models\Bulk;

class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function mitra(Request $request)
    {
        if ($request->ajax() || $request->isMethod('POST')) {
            $table = Mitra::all();
            return datatables()->of($table)->addIndexColumn()
                ->addColumn('responsive_id', function () {
                    return '';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)"  class="btn btn-icon btn-label-primary me-1 is-btn-user-edit" data-id="' . $row->id . '"><span class="ti ti-edit"></span></a>';
                    $btn .= '<a href="javascript:void(0)" class="btn btn-icon btn-label-danger is-btn-user-delete" data-id="' . $row->id . '"><span class="ti ti-trash-x"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return Lyn::view('mitra.mitra');
    }

    public function mitra_store(Request $request)
    {
        if (!$request->ajax()) return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
        $request->validate([
            'name' => 'required',
            'no_kontrak' => ['required', 'unique:mitra'],
            'nomor_hp' => ['required', 'numeric'],
            'masa_kontrak' => 'required',
        ]);

        $mitra = new Mitra();
        $mitra->name = $request->name;
        $mitra->no_kontrak = $request->no_kontrak;
        $mitra->nomor_hp = $request->nomor_hp;
        $mitra->masa_kontrak = $request->masa_kontrak;
        $mitra->save();
        
        $table = new Contact();
        $table->user_id = auth()->user()->id;
        $table->session_id = session()->get('main_device');
        $table->label_id = '5';
        $table->name = $request->name;
        $table->number = $request->nomor_hp;
        $table->save();


        return response()->json(['status' => 'success', 'message' => 'Mitra created successfully'], 200);
    }


    
    public function mitra_update(Request $request)
{
    if (!$request->ajax()) return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);

    $request->validate([
        'name' => 'required',
        'no_kontrak' => ['required', 'unique:mitra,no_kontrak,' . $request->id],
        'nomor_hp' => 'required',
        'masa_kontrak' => 'required',
    ]);

    $mitra = Mitra::find($request->id);
    if (!$mitra) return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
    $mitra->name = $request->name;
    $mitra->no_kontrak = $request->no_kontrak;
    $mitra->nomor_hp = $request->nomor_hp;
    $mitra->masa_kontrak = $request->masa_kontrak;
    $mitra->save();

    return response()->json(['status' => 'success', 'message' => 'Mitra updated successfully'], 200);
}


    public function mitra_edit(Request $request, $id)
    {
        if (!$request->ajax()) return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
        $mitra = Mitra::find($id);
        if (!$mitra) return response()->json(['status' => 'error', 'message' => 'mitra not found'], 404);
        return response()->json([
            'status' => 'success',
            'data' => $mitra
        ], 200);
    }

    public function mitra_delete(Request $request, $id)
    {
        if (!$request->ajax()) return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
        $mitra = Mitra::find($id);
        if (!$mitra) return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        if (Storage::exists($mitra->id)) {
            Storage::deleteDirectory($mitra->id);
        }
        Session::where('user_id', $mitra->id)->delete();
        ContactLabel::where('user_id', $mitra->id)->delete();
        Contact::where('name', $mitra->name)->delete();
        AutoResponder::where('user_id', $mitra->id)->delete();
        Bulk::where('user_id', $mitra->id)->delete();
        Campaigns::where('user_id', $mitra->id)->delete();
        $mitra->delete();

        // $mit1 = Mitra::where('id',$id)->get();
        // foreach ($mit1 as $mit) {
        //     $table = Contact::where([
        //         'name' => $mit->name,
        //         'user_id' => auth()->user()->id,
        //         'session_id' => session()->get('main_device')
        //     ])->first();
        //     if ($table) $table->delete();
        // }

        return response()->json(['status' => 'success', 'message' => 'Mitra deleted successfully'], 200);
    }
 
    public function destroy(string $id)
    {
        //
    }
}
