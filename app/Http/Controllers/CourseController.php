<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use \App\Models\Feedback;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$courses=Course::orderBy('period','desc')->get();
        $courses = DB::table('courses')->paginate(15);
        return view('courses.index',compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($course_code)
    {
        $course=Course::where('course_code', $course_code)->first();
        $feedbackBest=Feedback::where('course', $course_code)->where('feedback', 'NOT lIKE', '%IMAGE%')->orderBy('grade', 'desc')->take(10)->get();
        $feedbackWorst=Feedback::where('course', $course_code)->where('feedback', 'NOT lIKE', '%IMAGE%')->orderBy('grade', 'asc')->take(10)->get();
        return view('courses.show.index',['course'=> $course, 'feedbacksbest' => $feedbackBest]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
