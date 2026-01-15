<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // WAJIB ADA
use App\Models\Guest;
use App\Models\User;
use Filament\Notifications\Notification;

class GuestController extends Controller
{

    public function store(Request $request) 
{
    // 1. Simpan data ke database
    $guest = Guest::create([
        'nama' => $request->nama,
        'instansi' => $request->instansi,
        'telepon' => $request->telepon,
        'bidang' => $request->bidang,
        'keperluan' => $request->keperluan,
    ]);

    return redirect()->route('guest.success')->with([
        'nama_tamu' => $guest->nama,
        'bidang_tamu' => $guest->bidang,
        'id_tamu' => $guest->id
    ]);
}
}