<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Feedback;
use App\Models\Import;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImportController extends Controller
{
    public function getIndex()
    {
        return view('import.index', ['message' => " "]);
    }

    public function revert()
    {
        //$courses=Course::orderBy('period','desc')->get();
        $imports = DB::table('imports')->paginate(15);
        return view('import.revert.index', compact('imports'));
    }


    public function destroy($feedback)
    {
        Import::destroy($feedback);
        return redirect('/import/revert');
    }


    public function postIndex(Request $request)
    {
        $csvFile = $request->all()['file'];
        try {
            $hash = base64_encode(file_get_contents($csvFile));
        } catch (\Exception $e) {
            return view('import.index', ['message' => "Kies een bestand"]);
        }
        $hashDB = Import::where('hash', '=', $hash)->get();

        if (count($hashDB) > 0)
            return view('import.index', ['message' => "Upload bestaat al!"]);

        $csv = $this->csvToArray($csvFile);

        if (count($csv) == 0) {
            return view('import.index', ['message' => "Kies een geldig CSV bestand"]);
        }

        $import = new Import();
        $import->hash = $hash;
        $import->save();

        foreach ($csv as $data) {

            $course = new Course();

            if (Course::where('course_code', '=', $data['vakcode'])->first() == null) {


                $course->course_code = $data['vakcode'];
                $course->name = $data['vaknaam'];

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
            $feedback->period = $data['period'];
            $feedback->import = $import->id;
            $feedback->save();
        }

        return view('import.index', ['message' => "Upload klaar"]);
    }


    function csvToArray($filename = '', $delimiter = ';')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
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
