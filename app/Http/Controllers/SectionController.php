<?php

namespace App\Http\Controllers;

use App\Http\Resources\SectionsResource;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $class_id  = request('class_id',null);
        $sections = Section::where('class_id',$class_id)->get();

        return SectionsResource::collection($sections);
    }
}
