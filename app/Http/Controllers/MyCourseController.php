<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseRegistration;
use App\Models\Pendaftar;
use App\Models\Course;
use App\Models\Duty;
use App\Models\DutySubmission;
use App\Models\Exam;

class MyCourseController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Hanya ambil kursus yang user daftar (tanpa fallback)
        $registrations = CourseRegistration::with('course')
            ->where('user_id', $userId)
            ->get();

        $courses = $registrations->map(fn ($r) => $r->course)->filter()->values();

        return view('my_courses', [ 'courses' => $courses ]);
    }

    public function show(\App\Models\Course $course)
    {
        $userId = Auth::id();

        // Filter per course
        $schedules = \App\Models\Schedule::with(['attendances' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->where('course_id', $course->id)->get();

        foreach ($schedules as $schedule) {
            $schedule->is_presence_active = false;
            if ($schedule->start_time && $schedule->end_time) {
                $schedule->is_presence_active = now()->between(
                    $schedule->start_time,
                    $schedule->end_time
                );
            }
            $schedule->has_attended = $schedule->attendances->isNotEmpty();
        }

        // Duties + submission status for this user
        $duties = Duty::where('course_id', $course->id)->latest()->get();
        foreach ($duties as $duty) {
            $duty->submission = DutySubmission::where('user_id', $userId)
                ->where('duty_id', $duty->id)
                ->first();
        }

        // Exams list with question counts
        $exams = Exam::where('course_id', $course->id)->withCount('questions')->get();

        return view('my_course_detail', [
            'course' => $course,
            'schedules' => $schedules,
            'duties' => $duties,
            'exams' => $exams,
        ]);
    }
}