<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $paginate = request('paginate',10);
        $search_term = request('q','');

        $selectedClass = request('selectedClass');
        $selectedSection = request('selectedSection');

        $sort_direction = request('sort_direction','desc');

        if(!in_array($sort_direction,['asc','desc'])){
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field','created_at');
        if(!in_array($sort_field,['name','email','address','phone_number','created_at'])){
            $sort_field = 'created_at';
        }

        $students = Student::with(['class','section'])
        ->when($selectedClass,function($query) use ($selectedClass){
            $query->where('class_id',$selectedClass);
        })
        ->when($selectedSection,function($query) use ($selectedSection){
            $query->where('section_id',$selectedSection);
        })

        ->search(trim($search_term))
        ->paginate($paginate);

        return StudentResource::collection($students);

    }

    public function allStudents()
    {
        return Student::pluck('id');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->noContent();
    }

    public function massDestroy($students)
    {
        $studentsArray = explode(',',$students);
        Student::whereKey($studentsArray)->delete();
        return response()->noContent();
    }

    public function export($students)
    {
        $studentsArray = explode(',',$students);
        return (new StudentsExport($studentsArray))->download('students.xlsx');
    }
}
