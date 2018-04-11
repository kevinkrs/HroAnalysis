<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  \App\Models\Feedback;

class FeedbackController extends Controller
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


    public function destroy($feedback, $redirect)
    {
        Feedback::destroy($feedback);
        return redirect('/course/' . $redirect);
    }
}
