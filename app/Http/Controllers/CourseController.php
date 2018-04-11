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
            ->groupBy('grade')
            ->get();

        $gradeArray = array();
        $gradeAmounts = array();
        foreach ($grades as $grade) {
            array_push($gradeArray, $grade->grade);
            array_push($gradeAmounts, $grade->amount);
        }

        $average = round($this->averageGrade($grades),1);

        $chartjs = $this->generateBarChart($gradeArray,$gradeAmounts);

        return view('courses.show.index',
            [   'course' => $course,
                'feedbackbest' => $feedbackBest,
                'feedbackworst' => $feedbackWorst,
                'chartjs' => $chartjs,
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
        return $totalValue / $totalAmount;
    }

    function getFeedback($course_code, $order){
      $feedback = Feedback::where('course', $course_code)
            ->where('feedback', 'NOT lIKE', '%IMAGE%')
            ->where('grade', '>', '0')
            ->orderBy('grade', $order)
            ->paginate(10);

      return $feedback;
    }
    function generateBarChart($labels, $data){
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
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
