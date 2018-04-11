<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use \App\Models\Feedback;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$courses=Course::orderBy('period','desc')->get();
        $courses = DB::table('courses')->paginate(15);
        return view('courses.index', compact('courses'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($course_code)
    {
        $course = Course::find($course_code);
        $feedbackBest = Feedback::where('course', $course_code)
            ->where('feedback', 'NOT lIKE', '%IMAGE%')
            ->orderBy('grade', 'desc')
            ->take(10)
            ->get();
        $feedbackWorst = Feedback::where('course', $course_code)
            ->where('feedback', 'NOT lIKE', '%IMAGE%')
            ->where('grade', '<', '2')
            ->orderBy('grade', 'asc')
            ->take(10)
            ->get();

        $grades = DB::table('feedbacks')
            ->select('grade', DB::raw('count(*) as amount'))
            ->where('grade', '!=', '0')
            ->where('course', '=', $course_code)
            ->groupBy('grade')
            ->get();

        $gradeList = array();
        $gradeAmounts = array();
        foreach ($grades as $grade) {
            array_push($gradeList, $grade->grade);
            array_push($gradeAmounts, $grade->amount);
        }

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($gradeList)
            ->datasets([
                ["label" => "Cijfers",
                    'data' => $gradeAmounts,
                ]])
            ->options([
                'legend' => [
                    'display' => false,
                ],
            ]);

        return view('courses.show.index', ['course' => $course, 'feedbackbest' => $feedbackBest, 'feedbackworst' => $feedbackWorst, 'chartjs' => $chartjs]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_code)
    {
        Course::destroy($course_code);
        return redirect('/course');
    }
}
