<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Employee;
use App\Models\Lesson;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentClass;
use Carbon\Carbon;

class scheduleController extends BaseController
{
    public function index(Request $request) {

        $testEmployee = Employee::first();

        $employeeLessons = Lesson::where('employee', $testEmployee->api_id)->get();
        $lessonClassAndStudents = collect([]);
    
        $employeeLessons->each(function($lesson) use ($lessonClassAndStudents){
    
            $studentIds = StudentClass::where('class_id', $lesson->class_id)->pluck('student_id');
            $class = SchoolClass::where('api_id', $lesson->class_id)->first();
            $students = Student::whereIn('api_id', $studentIds)->get();
    
            $lessonClassAndStudents->push(
                [
                    'day' => Carbon::createFromDate($lesson->start_at)->englishDayOfWeek,
                    'Subject' => $class->subject,
                    'lesson' => $lesson,
                    'class' => $class,
                    'students' => $students
                ]
            );
        });
    
        dd($lessonClassAndStudents);
    
        return view('schedule');
    }
}