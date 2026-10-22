<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // list students + search by name or roll no
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('name', 'like', "%$s%")
                  ->orWhere('roll_no', 'like', "%$s%");
        }

        $students = $query->orderBy('roll_no')->paginate(10)->withQueryString();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'roll_no' => 'required|unique:students,roll_no',
            'name'    => 'required|string|max:100',
            'class'   => 'required|string|max:50',
        ]);

        Student::create($data);
        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'roll_no' => 'required|unique:students,roll_no,' . $student->id,
            'name'    => 'required|string|max:100',
            'class'   => 'required|string|max:50',
        ]);

        $student->update($data);
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}