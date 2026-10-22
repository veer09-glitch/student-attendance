<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // list attendance records with filter by subject and date
    public function index(Request $request)
    {
        $query = Attendance::with(['student', 'subject']);

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->orderByDesc('date')->paginate(10)->withQueryString();
        $subjects = Subject::orderBy('name')->get();

        return view('attendances.index', compact('attendances', 'subjects'));
    }

    // mark attendance page: choose subject + date, then mark each student
    public function create(Request $request)
    {
        $subjects = Subject::orderBy('name')->get();
        $students = Student::orderBy('roll_no')->get();
        $date = $request->input('date', now()->toDateString());
        $subjectId = $request->input('subject_id');

        // if attendance was already marked, show the saved status
        $existing = [];
        if ($subjectId) {
            $existing = Attendance::where('subject_id', $subjectId)
                ->whereDate('date', $date)
                ->pluck('status', 'student_id')
                ->toArray();
        }

        return view('attendances.create', compact('subjects', 'students', 'date', 'subjectId', 'existing'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'date'       => 'required|date',
            'status'     => 'required|array',
            'status.*'   => 'in:present,absent',
        ]);

        foreach ($request->status as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id,
                    'date'       => $request->date,
                ],
                ['status' => $status]
            );
        }

        return redirect()->route('attendances.index')->with('success', 'Attendance saved successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Attendance record deleted successfully.');
    }

    // report: total, present, absent and percentage for each student
    public function report(Request $request)
    {
        $subjects = Subject::orderBy('name')->get();
        $students = Student::orderBy('roll_no')->get();

        $query = Attendance::query();
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $totals = $query
            ->selectRaw("student_id, COUNT(*) as total, SUM(status = 'present') as present")
            ->groupBy('student_id')
            ->get()
            ->keyBy('student_id');

        return view('attendances.report', compact('subjects', 'students', 'totals'));
    }
}