<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\Lyn;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function profile()
    {
        $user = auth()->user(); // Mengambil objek user yang sedang login
    
        return Lyn::view('profile.profile', compact('user')); // Mengirim objek user ke view
    }


    public function destroy(string $id)
    {
        //
    }
}
