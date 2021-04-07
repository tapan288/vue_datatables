<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $paginate = request('paginate',10);

        $students = Student::with(['class','section'])->paginate($paginate);
        return StudentResource::collection($students);

    }
}
