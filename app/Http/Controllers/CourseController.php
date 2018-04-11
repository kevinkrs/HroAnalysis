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
        $feedbackBest = $this->getFeedback($course_code, 'desc');
        $feedbackWorst = $this->getFeedback($course_code, 'asc');

        $grades = DB::table('feedbacks')
            ->select('grade', DB::raw('count(*) as amount'))
            ->where('grade', '!=', '0')
            ->where('course', '=', $course_code)
            ->orderBy('grade')
            ->groupBy('grade')
            ->get();


        $gradesAVG = DB::table('feedbacks')
            ->select('period', DB::raw('avg(grade) as average'))
            ->where('grade', '!=', '0')
            ->where('course', '=', $course_code)
            ->orderBy('period')
            ->groupBy( 'period')
            ->get();



        $gradeArray = array();
        $gradeAmounts = array();
        foreach ($grades as $grade) {
            array_push($gradeArray, $grade->grade);
            array_push($gradeAmounts, $grade->amount);
        }

        $gradeArrayAVG = array();
        $gradeAmountsAVG = array();
        foreach ($gradesAVG as $grade) {
            array_push($gradeArrayAVG, $grade->period);
            array_push($gradeAmountsAVG, round($grade->average,2 ));
        }





        $chartjs = $this->generateChart($gradeArray,$gradeAmounts,"grades", "bar");
        if(count($gradeArrayAVG) >= 2)
            $chartjsAVG = $this->generateChart($gradeArrayAVG,$gradeAmountsAVG ,"gradeavg", "line");
        else
            $chartjsAVG = $this->generateChart($gradeArrayAVG,$gradeAmountsAVG ,"gradeavg", "bar");

        $average = round($this->averageGrade($grades),1);

        return view('courses.show.index',
            [   'course' => $course,
                'feedbackbest' => $feedbackBest,
                'feedbackworst' => $feedbackWorst,
                'chartjs' => $chartjs,
                'chartjsAVG' => $chartjsAVG,
                'average' => $average
            ]);
    }

    function averageGrade($grades){
        $totalAmount = 0;
        $totalValue = 0;
        foreach($grades as $grade){
            $totalAmount += $grade->amount;
            $totalValue += $grade->grade * $grade->amount;
        }
        if($totalAmount != 0 && $totalValue != 0)
            return $totalValue / $totalAmount;
        else
            return 0;
    }

    function getFeedback($course_code, $order){
      $feedback = Feedback::where('course', $course_code)
            ->where('feedback', 'NOT lIKE', '%IMAGE%')
            ->where('grade', '>', '0')
            ->orderBy('grade', $order)
            ->paginate(10);
      return $feedback;
    }

    function generateChart($labels, $data, $name, $type){
        $chartjs = app()->chartjs
            ->name($name)
            ->type($type)
            ->labels($labels)
            ->datasets([
                ["label" => "Cijfers",
                    'data' => $data,
                ]])
            ->options([
                'legend' => [
                    'display' => false,
                ],
            ]);

        return $chartjs;
    }

    public function destroy($course_code)
    {
        Course::destroy($course_code);
        return redirect('/course');
    }
}
