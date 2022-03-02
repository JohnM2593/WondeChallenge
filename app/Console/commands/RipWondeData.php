<?php

namespace App\Console\Commands;

use App\Models\ClassStudent;
use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\Lesson;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Subject;
use Wonde\Client;

class RipWondeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rip-wonde-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull the relavant data from wonde api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @param  \App\Support\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        //Execution time, around 90 seconds (Not too bad)

        //contact api and authenticate
        $apiToken = '718ac89aaeb2aa413f679413a7d80736065c55ee';
        $schoolId = 'A1930499544';
    
        $client = new Client($apiToken);
        $client->requestAccess($schoolId);
        $school = $client->school($schoolId);

        //Beginning and end of week for lessons parameters
        $startOfWeek = now()->startOfWeek()->toDayDateTimeString();
        $endOfWeek = now()->endOfWeek()->toDayDateTimeString();

        //Get the subjects, no data in code or names though
        foreach($school->subjects->all() as $subject) {
            Subject::create([
                "api_id" => $subject->id,
                "code" => $subject->code,
                "name" => $subject->name,
            ]);
        };

        //Get employees with the relevant data
        foreach($school->employees->all(['employment_details', 'classes']) as $employee){
            if($employee->classes->data !== [] && $employee->employment_details->data->current !== false){
                Employee::create([
                    "api_id" => $employee->id,
                    "upi" => $employee->upi,
                    "mis_id" => $employee->mis_id,
                    "initials" => $employee->initials,
                    "title" => $employee->title,
                    "surname" => $employee->surname,
                    "forename" => $employee->forename,
                    "middle_names" => $employee->middle_names,
                    "legal_surname" => $employee->legal_surname,
                    "legal_forename" => $employee->legal_forename,
                    "gender" => $employee->gender,
                ]);
            }
        }

        //Store lessons for the upcomming week
        foreach ($school->lessons->all(['employee', 'class'], ['lessons_start_after' => $startOfWeek, 'lessons_start_before' => $endOfWeek]) as $lesson) {
            if($lesson->employee !== null && $lesson->class !== null) {
                Lesson::create([
                    "api_id" => $lesson->id,
                    "class_id" => $lesson->class->data->id,
                    "room" => $lesson->room,
                    "period" => $lesson->period,
                    "period_instance_id" => $lesson->period_instance_id,
                    "employee" => $lesson->employee->data->id,
                    "start_at" => $lesson->start_at->date
                ]);
            }
        }

        //Store classes
        foreach($school->classes->all() as $class) {
            SchoolClass::create([
                "api_id" => $class->id,
                "mis_id" => $class->mis_id,
                "name" => $class->name,
                "code" => $class->code,
                "description" => $class->description,
                "subject" => $class->subject,
                "alternative" => $class->alternative,
            ]);
        }

        //store students
        foreach($school->students->all(['classes']) as $student) {
            if($student->id !== null) {
                Student::create([
                    "api_id" => $student->id,
                    "upi" => $student->upi,
                    "mis_id" => $student->mis_id,
                    "initials" => $student->initials,
                    "surname" => $student->surname,
                    "forename" => $student->forename,
                    "middle_names" => $student->middle_names,
                    "legal_surname" => $student->legal_surname,
                    "legal_forename" => $student->legal_forename,
                    "gender" => $student->gender,
                ]);
            }

            //store classes and their students as a pivot
            if($student->classes->data !== [] && $student->id !== null) {
                foreach($student->classes->data as $class) {
                    StudentClass::create([
                        'student_id' => $student->id,
                        'class_id' => $class->id
                    ]);
                }
            }
        } 
    }
}