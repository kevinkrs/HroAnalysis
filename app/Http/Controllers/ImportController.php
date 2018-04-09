<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Import;
use App\Models\Location;
use DebugBar\DebugBar;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function Index()
    {
        $csv = $this->csvToArray('data.csv');

//        $import = new Import();
//        $import->save();
//
//        $course = new Course();
//        $course->course_code = 'CCOCKB10R3(vakcode)';
//        $course->name = 'Brandmanagement(vaknaam)';
//        $course->period = '16/17-03(period)';
//        $course->save();
//
//        $location = new Location();
//        $location->location_code = 'WH';
//        $location->name = 'WH(location)';
//        $location->save();

        foreach($csv as $data) {

//            $dbcourse = Course::where('course_code')->first($data['vakcode']);

            $dbcourse = Course::where('course_code', $data['vakcode'])->first();

//                $dbcourse = Course::all();

//                print_r($dbcourse->toArray());

//            Debugbar::info($dbcourse);

//             \Debugbar::info($dbcourse);


//            echo $dbcourse->course_code;





//            $course = new Course();
//            $course->course_code = $data['vakcode'];
//            $course->name = $data['vaknaam'];
//            $course->period = '16/17-03(period)';
//            $course->save();

            //print_r($data['comments']);

        }


        return view('import.index');
    }



    function csvToArray($filename = '', $delimiter = ';')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}
