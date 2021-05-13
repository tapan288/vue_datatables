<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Exports\StudentsExport;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
    public function index()
    {
        $paginate = request('paginate');

        if (isset($paginate)) {
            $students = Student::studentsQuery()->paginate($paginate);
        } else {
            $students = Student::studentsQuery()->get();
        }

        return StudentResource::collection($students);
    }


    public function destroy(Student $student)
    {
        $student->delete();
        return response()->noContent();
    }

    public function massDestroy($students)
    {
        $studentsArray = explode(',', $students);
        Student::whereKey($studentsArray)->delete();
        return response()->noContent();
    }

    public function export($students)
    {
        $studentsArray = explode(',', $students);
        return (new StudentsExport($studentsArray))->download('students.xlsx');
    }
}
