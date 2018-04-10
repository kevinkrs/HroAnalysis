<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Feedback;
use App\Models\Import;
use App\Models\Location;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function getIndex()
    {
        return view('import.index');
    }


    public function postIndex(Request $request)
    {
        $csvFile = $request->all()['file'];


        $csv = $this->csvToArray($csvFile);


        $import = new Import();
        $import->save();

        foreach ($csv as $data) {

            $course = new Course();

            if (Course::where('course_code', '=', $data['vakcode'])->first() == null) {


                $course->course_code = $data['vakcode'];
                $course->name = $data['vaknaam'];
                $course->period = '16/17-03(period)';
                $course->save();
            }


            $location = new Location();

            if (Location::where('location_code', '=', $data['location'])->first() == null) {

                $location->location_code = $data['location'];
                $location->name = $data['location'];
                $location->save();
            }


            $feedback = new Feedback();
            $feedback->feedback = $data['comments'];

            if ($data['rapportcijfer'] == '') {

                $feedback->grade = '0';
            } else {
                $feedback->grade = $data['rapportcijfer'];
            }
            $feedback->timestamp_received_date = new \DateTime(explode(" at ", $data['timestamp'])[0]);
            $feedback->class_code = $data['last_name'];
            $feedback->course = $data['vakcode'];
            $feedback->location = $data['location'];
            $feedback->import = $import->id;
            $feedback->save();
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
