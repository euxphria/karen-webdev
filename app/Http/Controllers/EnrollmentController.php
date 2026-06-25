<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnrollmentController extends Controller
{
    public function index()
    {
        $student = DB::table('enrolled_students')
            ->where('email', auth()->user()->email)
            ->first();

        if (!$student) {
            return redirect()->route('home')
                ->withErrors(['Student record not found.']);
        }

        $subjects = DB::table('subjects')
            ->leftJoin('sections', 'subjects.course_code', '=', 'sections.course_code')
            ->select(
                'subjects.id as subject_id',
                'subjects.course_code',
                'subjects.course_name',
                'subjects.units',
                'subjects.program',
                'subjects.year_level',

                'sections.id as section_id',
                'sections.section_code',
                'sections.day_schedule',
                'sections.start_time',
                'sections.end_time',
                'sections.professor',
                'sections.max_students'
            )
            ->where('subjects.program', $student->program)
            ->where('subjects.year_level', $student->year)
            ->get();

        $grouped = $subjects->groupBy('course_code');

        $alreadyEnrolled = DB::table('enrollments')
            ->where('user_id', auth()->id())
            ->exists();

        return view('enrollment', compact(
            'grouped',
            'student',
            'alreadyEnrolled'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sections' => ['required', 'array']
        ], [
            'sections.required' => 'Please select a schedule for each subject.'
        ]);

        foreach ($request->sections as $subjectId => $sectionId) {

            $section = DB::table('sections')
                ->where('id', $sectionId)
                ->first();

            if (!$section) {
                continue;
            }

            $count = DB::table('enrollments')
                ->where('section_id', $sectionId)
                ->count();

            if ($count >= $section->max_students) {
                return back()->withErrors([
                    'sections' => "Section {$section->section_code} is already full."
                ]);
            }

            DB::table('enrollments')->insert([
                'user_id' => auth()->id(),
                'subject_id' => $subjectId,
                'section_id' => $sectionId,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info("Student enrolled in subject {$subjectId} section {$sectionId}");
        }

        return redirect()
            ->route('enrollment.index')
            ->with('success', 'Enrollment submitted successfully.');
    }
}