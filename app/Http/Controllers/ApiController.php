<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Student;
use App\Models\School;


class ApiController extends Controller
{
    //

    public function getAllStudents()
    {
        // logic to get all students goes here
        $students = Student::get()->toJson(JSON_PRETTY_PRINT);
        return response($students, 200);
    }

    public function createStudent(Request $request)
    {
        // logic to create a student record goes here
        $student = new Student;
        $student->name = $request->name;
        $student->course = $request->course;
        $student->save();
        $last_insert_id = $student->id;

        return response()->json([
            "message" => "student record created",
            "id" => $last_insert_id
        ], 201);
    }

    public function getStudent(Student $student)
    {
        // logic to get a student record goes here
        if (Student::where('id', $student->id)->exists()) {
            $student = Student::where('id', $student->id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($student, 200);
        } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }

    public function updateStudent(Request $request, $id)
    {
        // logic to update a student record goes here
        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->name = is_null($request->name) ? $student->name : $request->name;
            $student->course = is_null($request->course) ? $student->course : $request->course;
            $student->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }

    public function deleteStudent($id)
    {
        // logic to delete a student record goes here
        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }


    public function createSchool(Request $request)
    {
        // logic to create a student record goes here
        $school = new School;
        $school->studentId = $request->studentId;
        $school->save();
        $last_insert_id = $school->id;

        return response()->json([
            "message" => "school record created",
            "id" => $last_insert_id
        ], 201);
    }
}
