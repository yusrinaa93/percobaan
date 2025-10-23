<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class MyCourseController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Gunakan with() untuk Eager Loading relasi attendances
        // Kita hanya memuat presensi milik user yang sedang login
        $schedules = Schedule::with(['attendances' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->get();

        foreach ($schedules as $schedule) {
            // Cek status waktu presensi
            $schedule->is_presence_active = false;
            if ($schedule->start_time && $schedule->end_time) {
                $schedule->is_presence_active = now()->between(
                    $schedule->start_time,
                    $schedule->end_time
                );
            }

            // Cek apakah user sudah presensi
            // Sekarang tidak ada kueri tambahan, karena data sudah dimuat
            $schedule->has_attended = $schedule->attendances->isNotEmpty();
        }

        $materials = [];

        return view('my_courses', [
            'schedules' => $schedules,
            'materials' => $materials
        ]);
    }
}