<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    /**
     * Menyimpan data presensi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        // Cek agar tidak ada presensi ganda
        Attendance::firstOrCreate([
            'user_id' => Auth::id(),
            'schedule_id' => $request->schedule_id,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Presensi berhasil dicatat!']);
    }
}