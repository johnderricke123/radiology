<?php

namespace App\Http\Controllers;

use App\DicomAllPatient;
use App\DicomServer as AppDicomServer;
use App\SecondDatabaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Test;
use App\Exam;
use App\Result;
use App\DicomServer;
use App\Patient;
use App\Findings;
use App\Result as AppResult;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DicomPatientController extends Controller
{
    
    public function all(Request $request){

        //THis week
        
        $monday = strtotime('last monday', strtotime('tomorrow'));
        $sunday = strtotime('+6 days', $monday);
        $date1 = date('Ymd', $monday);
        $date2 = date('Ymd', $sunday);
   
   
        $results = DB::connection('sqlite_second')->table('DICOMStudies')
        ->orderBy('StudyDate','DESC')->take(6)->get();
        
        //var_dump($check);die();

            if($request->has('date_filter')){
            
             $date_filter = explode(" - ",$request->input('date_filter'));
                 
            $date1 = str_replace("-","",$date_filter[0]);
            $date2 = str_replace("-","",$date_filter[1]);
                $results = DicomServer::whereBetween('StudyDate', [$date1, $date2])
                    ->orderBy('StudyDate','DESC')->get();
            }
   
            if ($request->has('filter')){
               $results = DicomServer::all();
               
           }  else {
               $results = DicomServer::whereBetween('StudyDate', [$date1, $date2])
               ->orderBy('StudyDate','ASC')->get();
            }
// ************************CHECKS IF RESULTS HAS REPORTS ALREADY************************
        $results = check_for_reports($results);
// ************************CHECKS IF RESULTS HAS REPORTS ALREADY************************
        return view('dicom.all', [
            'results' => $results
        ]);
   
       }
//**********************************ORGANIZE STUDY FEATURE***************************************
       public function all_patient_list(){
        // $date = Carbon::now()->subDays(30)->toDateString();
        // $date2 = Carbon::createFromFormat('Y-m-d', $date)->format('Ymd');
        // return $date2;

        $patients = DicomAllPatient::Orderby('PatientID','DESC')->get()->take(20);
        return view('dicom.all_patient_list', [
            'patients' => $patients
        ]);
       }

       public function patient_studies($id){
        $studies = DicomServer::Orderby('StudyDate','DESC')->where('PatientID', $id)->get();
        $studies = check_for_reports($studies);
        //var_dump($studies);die();
        return view('dicom.patient_study_list', [
            'studies' => $studies
        ]);

       }
//**********************************ORGANIZE STUDY FEATURE***************************************
    public function search(Request $request){

        $searched_data = $request->nameOrPatientId;
        $results = DB::connection('sqlite_second')
                ->table('DICOMStudies')
                ->where('PatientNam', 'like', "%$searched_data%")
                ->orWhere('PatientID', 'like', "%$searched_data%")
                ->get();
//var_dump($results);die();
                $check = array();
                foreach($results as $res){

// CHECK IF STUDY INSTA HAS OLD STUDY INSTA ON UIDMODS TABLE
$old_study_insta = DB::connection('sqlite_second')
->table('UIDMODS')
->where('NewUID', $res->StudyInsta)
->get() ?: null;

                    $check['study_instance'][] = $res->StudyInsta; 
                    $check_result = Result::where('study_instance', $res->StudyInsta)->get();
                    //var_dump($check_result);die();0
                    $check['hasReport'][] = $res->StudyInsta;
                }
// var_dump($check);die();
// *******************************CODE FOR DISABLING MAKE REPORT BUTTON WHEN REPORT IS ALREADY GENERATED************************
$i = 0;
foreach($results as $res){
    $checking = Result::where('study_instance', $res->StudyInsta)->get();    
    if($checking->isNotEmpty()){
        $res->hasReport = 1;
    } else {

    $check_mods = DB::connection('sqlite_second')
    ->table('UIDMODS')
    ->where('NewUID', $res->StudyInsta)
    ->select('UIDMODS.OldUID')
    ->get();

        if($check_mods->isNotEmpty()){
        
            $checking2nd = Result::where('study_instance', $check_mods[0]->OldUID)->get();
            if($checking2nd->isNotEmpty()){
                $res->hasReport = 1;
            }else{
                $res->hasReport = 0;
            }
        }else{
            $res->hasReport = 0;
        }
    }
    $i++;
}
// *******************************CODE FOR DISABLING MAKE REPORT BUTTON WHEN REPORT IS ALREADY GENERATED************************

                return view('dicom.all', [
                    'results' => $results
                ]);
    }

    public function view_patient(Request $request, $id,$study_insta = null, $reportId = null){
        //return $reportId;
        //return $study_insta;
        // return $id;
        //return $request->all();
        $tests = Test::all();
       
        $results = DB::connection('sqlite_second')
                ->table('DICOMStudies')
                ->join('DICOMSeries', 'DICOMStudies.PatientID', '=', 'DICOMSeries.SeriesPat')
                ->where('DICOMStudies.PatientID', $id)
                ->where('DICOMStudies.StudyInsta', $request->study_insta ?: $study_insta)
                ->select('DICOMStudies.*','DICOMSeries.SeriesDesc','DICOMSeries.SeriesNumb','DICOMSeries.BodyPartEx')
                ->first();
       
        $patient_name = str_replace("^",", ",$results->PatientNam);    
   
        $p_name = explode("^", $results->PatientNam);
        $name = $p_name[0];

        $f_name[0]='';
        if(isset($p_name[1])){
            $f_name = explode(" ", $p_name[1]);
        }
        $fname = '';
        
        if(isset($f_name[1])) {
            $fname = $f_name[1];
        }
        $first_name = $f_name[0]. ' '. $fname;
        $middle_name = end($f_name);


        $physicians = User::where('role','physician')->orderBy('name', 'ASC')->get(); // GET all physicians for dropdown
        $refered_phys = '';
//TESTING
    $phy_code = $results->ReferPhysi;
    $char = "/";
    if (strpos($phy_code, $char) !== false) {
        $pieces = explode("/", $phy_code);
        $code =  $pieces[1];
    } else {
        $code =  $phy_code;
    }
//TESTING

        // if($results->ReferPhysi) {  //Get Name of Physician in USERs  From Initials of DICOM Entry
        //     $refering_physician = User::where('title', '=', $results->ReferPhysi)->where('role','physician')->first();
        //     if(!empty($refering_physician)){
        //         $refered_phys = $refering_physician->id;
        //     }
        // }

        if($code) {  //Get Name of Physician in USERs  From Initials of DICOM Entry
            $refering_physician = User::where('title', '=', $code)->where('role','physician')->first();
            if(!empty($refering_physician)){
                $refered_phys = $refering_physician->id;
            }
        }
//return $refered_phys;
        $patient_info = [
            "name" => $name,
            "first_name" => $first_name,
            "middle_name" => $middle_name,
            "study_modality" => $results->StudyModal,
            "birthday" =>  $results->PatientBir,
            "gender" => $results->PatientSex

        ];
        $title = 'Enter Result';
       
        return view('dicom.view_modality', [
            'results' => $results,
            'tests' => $tests,
            'title' => $title,
            'patient_info' => $patient_info,
            'id' => '',
            'test_id' => '',
            'refered_phys' => $refered_phys,
            'refering_phys' => $results->ReferPhysi,
            'physicians' => $physicians,
            'reportId' => $reportId
        ]);
    }
    public function generate_findings(Request $request){											

        DB::table('results')->insert([
            'patient_id' => 'kayla@example.com',
            'dicom_patient_id' => 'kayla@example.com',
            'exam_number' => 'kayla@example.com',
            'study_instance' => 'kayla@example.com',
            'test_id' => 'kayla@example.com',
            'exam_id' => 'kayla@example.com',
            'result' => 'kayla@example.com',
            'remarks' => 'kayla@example.com',
            'created_by' => 'kayla@example.com',
            'created_at' => 'kayla@example.com',
            'updated_at' => 'kayla@example.com'
        ]);

        $text = nl2br($request->findings);
        $impression = nl2br($request->impression);
        
    //    // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('user_template.docx'));
    //     $templateProcessor->setValue('name', $request->name);
    //     //$templateProcessor->setValue('patient', $user->id);
    //     $templateProcessor->setValue('rNo', $request->roomNumber);
    //     $templateProcessor->setValue('datePerformed', $request->datePerformed);
    //     $templateProcessor->setValue('eNo', $request->examNumber);
    //     $templateProcessor->setValue('cNo', $request->caseNumber);
    //     $templateProcessor->setValue('age', $request->age);
    //     $templateProcessor->setValue('sex', $request->sex);
    //     $templateProcessor->setValue('bdate', $request->birthDate);
    //     $templateProcessor->setValue('cs', $request->cs);
    //     $templateProcessor->setValue('pNo', $request->plateNumber);
    //     $templateProcessor->setValue('patientNo', $request->patientID);
    //     $templateProcessor->setValue('examination', $request->examination);
    //     $templateProcessor->setValue('findings', (string)$text);
    //     $templateProcessor->setValue('impression', $impression);
    //     $templateProcessor->setValue('physician', $request->physician);
    //     $filename = date("Y-m-d H:i:s").$request->name;
    //     $templateProcessor->saveAs(storage_path("testing".'.docx'));
        return response()->download(storage_path("testing".'.docx'));

    }

    public function enter_result($id){
        $tests = Test::all();
       
        $results = DB::connection('sqlite_second')
                ->table('DICOMSeries')
                ->where('PatientID', $id)
                ->first();
                
        return response()->json($results);

    }

   

    public function getExam($id)
    {
        $exams = Exam::where('test_id',$id)->get();
        return response()->json($exams);
    }

    public function patient_print_report($id){
        
        $results = DB::table('results')
        ->where('results.id', $id)
        ->join('patients', 'patients.id', '=', 'results.patient_id')
        ->join('tests', 'tests.id', '=', 'results.test_id')
        ->join('users', 'users.id', '=', 'results.created_by')
        ->select('results.*', 'results.created_at as result_table_created_at','results.id as result_table_id', 'results.dicom_patient_id as dp_id', 'patients.*', 'tests.*','users.name as user_name','users.first_name as user_first_name','users.middle_name as user_middle_name','users.position as user_position','users.image as esign')
        ->first();
  //return $results;      
//var_dump();die();
        $findings = DB::table('findings')
        ->where('findings.result_id', $id)
        //->join('tests', 'tests.id', '=', 'findings.test')
        ->select('findings.*')
        ->get();
        //return $findings;
        
        $refering_phys = DB::table('users')
        ->where('id','=',$results->refering_phys)
        ->first();
    //  return $refering_phys;
        return view('dicom.print_report', [
            'results' => $results,
            'findings' => $findings,
            'refering_phys' => $refering_phys
        ]);

    }

    public function download_dicom_folder($id){
        //var_dump($id); die();
        // $folderPath = 'C:/testfolder/242619202402';
        $folderPath = 'C:/dicomserver/data/'.$id;
        
        // Ensure the folder exists using PHP's file system functions
        if (!file_exists($folderPath) || !is_dir($folderPath)) {
            abort(404, 'Folder not found');
        }
        
        // If the folder exists, continue with your logic
        
        
        // Define a temporary location to store the zip file
        // $zipFile = storage_path('app/temporary.zip');
        $zipFile = storage_path('app/'.$id.'.zip');
        
        // Create a new ZipArchive instance
        $zip = new ZipArchive();
        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Failed to create temporary zip file');
        }

        // Add all files from the folder to the zip file
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folderPath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        
        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($folderPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();

        // Set headers to download the zip file
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }

    public function view_dcm_file($id, $studyIns){
        //var_dump($studyIns);die();

        $results = DB::connection('sqlite_second')
        ->table('DICOMStudies')
        ->where('PatientID', $id)
        ->where('StudyInsta', $studyIns)
        ->first();

// ******************CHECKS IF STUDY IS MODIFIED OR NOT******************
        $checkModification = DB::connection('sqlite_second')
        ->table('UIDMODS')
        ->where('NewUID', $studyIns)
        ->select('UIDMODS.OldUID', 'UIDMODS.NewUID')
        ->first();
// ******************CHECKS IF STUDY IS MODIFIED OR NOT******************
        if ( is_null($checkModification) ) {
           $len = 0;
        }else{
            $OldUID = $checkModification->OldUID;
            $len = Str::length($OldUID);        
        }
          
        
        if($len > 0){
            $reports = DB::table('results')
            ->where('study_instance', $checkModification->OldUID)
            ->join('findings', 'results.id', '=', 'findings.result_id')
            ->orderBy('created_at', 'desc')
            ->select('results.id','results.created_at','results.study_instance','findings.findings')
            ->get();    
        }else{
            
            $reports = DB::table('results')
            ->where('study_instance', $studyIns)
            ->join('findings', 'results.id', '=', 'findings.result_id')
            ->orderBy('created_at', 'desc')
            ->select('results.id','results.created_at','results.study_instance','findings.findings')
            ->get();    
        }

        // $reports = DB::table('results')
        // ->where('study_instance', $studyIns)
        // ->join('findings', 'results.id', '=', 'findings.result_id')
        // ->orderBy('created_at', 'desc')
        // ->select('results.id','results.created_at','results.study_instance','findings.findings')
        // ->get();


        $birthDate = Carbon::createFromFormat('Ymd', $results->PatientBir)->format('m/d/Y');
        //date in mm/dd/yyyy format; or it can b e in other formats as well
        //explode the date to get month, day and year
        $birthDate = explode("/", $birthDate);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
            ? ((date("Y") - $birthDate[2]) - 1)
            : (date("Y") - $birthDate[2]));

        return view('dicom.view_dcm_file', [
            'reports' => $reports,
            'results' => $results,
            'age' => $age
        ]);

    }

    public function update_result(Request $request, $id){
       
        $tests = Test::all();
       
        $results = Result::where('results.id',$id)        
        ->join('tests', 'tests.id', '=', 'results.test_id')
        ->join('users', 'users.id', '=', 'results.created_by')
        ->select('results.*', 'results.created_at as result_table_created_at','results.id as result_table_id', 'results.dicom_patient_id as dp_id', 'tests.*','users.name as user_name')
        ->first();
       
        $user_logged = Auth::user();


       $findings = Findings::where('result_id', $id)->get();

        $patient_info = Patient::where('id', $results->patient_id)->first();
        
        $title = 'Update Result';
     

        $results['StudyInsta'] = $results->study_instance;
        $results['PatientID'] = $results->dicom_patient_id;
        $results['refering_phys'] = $results->refering_phys;
        $results['SeriesDesc'] = $results->series_desc;
        $results['BodyPartEx'] = $results->body_part;
        $results['SeriesNumb'] = $results->series_num;
        $results['StudyDate'] = $results->study_date;
        $results['created_by'] = $user_logged->id;
        $results['modality'] = $results->modality;
        $title = 'Update Result';

        $refered_phys = '';
        if($results->refering_phys){
            $refered = User::where('title','=',$results->refering_phys)->first();
            if(!empty($refered)) {
                $refered_phys = $refered->id;
            }            
        }


        $physicians = User::where('role','physician')->orderBy('name', 'ASC')->get();

        return view('dicom.view_modality', [
            'results' => $results,
            'tests' => $tests,
            'title' => $title,
            'patient_info' => $patient_info,
            'id' => $id,
            'findings' => $findings,
            'physicians' => $physicians,
            'physician_id' => $refered_phys,
            'refered_phys' => $refered_phys
        ]);
    }

    public function view_report_popup($id, $studyIns){
        //var_dump("view_report_popup");die();

        $results = DB::connection('sqlite_second')
        ->table('DICOMStudies')
        ->where('PatientID', $id)
        ->where('StudyInsta', $studyIns)
        ->first();

// ******************CHECKS IF STUDY IS MODIFIED OR NOT******************
        $checkModification = DB::connection('sqlite_second')
        ->table('UIDMODS')
        ->where('NewUID', $studyIns)
        ->select('UIDMODS.OldUID', 'UIDMODS.NewUID')
        ->first();
// ******************CHECKS IF STUDY IS MODIFIED OR NOT******************

if ( is_null($checkModification) ) {
    $len = 0;
 }else{
     $OldUID = $checkModification->OldUID;
     $len = Str::length($OldUID);        
 }
 if($len > 0){
    // var_dump("1");die();
    $reports = DB::table('results')
    ->where('study_instance', $checkModification->OldUID)
    ->join('findings', 'results.id', '=', 'findings.result_id')
    ->join('patients', 'results.patient_id', '=', 'patients.id')
    ->join('users', 'results.created_by', '=', 'users.id')
    ->orderBy('created_at', 'desc')
    ->select('users.name as creator_lname','users.first_name as creator_fname','results.id','results.modality','results.study_date','results.created_at','results.study_instance','findings.findings','patients.first_name as pfname','patients.name as plname')
    ->get();    
}else{
    // var_dump($studyIns."<br>");
    // var_dump("2");die();    
    $reports = DB::table('results')
    ->where('study_instance', $studyIns)
    ->join('findings', 'results.id', '=', 'findings.result_id')
    ->join('patients', 'results.patient_id', '=', 'patients.id')
    ->join('users', 'results.created_by', '=', 'users.id')
    ->orderBy('created_at', 'desc')
    ->select('users.name as creator_lname','users.first_name as creator_fname','results.id','results.modality','results.study_date','results.created_at','results.study_instance','findings.findings','patients.first_name as pfname','patients.name as plname')
    ->get();    
}


//var_dump($reports);die();

$result_count = count($reports);
if($result_count > 0){
    $dateString = $reports[0]->study_date;
    $date = Carbon::parse($dateString);
    $formattedDate = $date->format('d-M-Y h:i A');

    $fname = $reports[0]->pfname;
    $lname = $reports[0]->plname;
    $modality = $reports[0]->modality;
    $creator_lname = $reports[0]->creator_lname;
    $creator_fname = $reports[0]->creator_fname;
    echo '
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <br>
        <div class="row">
            <div class="col"><center><span><b>'.$lname.", ".$fname.'</b></span></center></div>
            <div class="col"><center> Study Date: <b>'.$formattedDate.'</b> </center></div>
        </div>
        <div class="row">
            <div class="col">
                <center> <span>Modality: <b>'.$modality.'</b></span> </center>
            </div>
            <div class="col">
                <center> <span>Reader: <b>'.$creator_lname.", ".$creator_fname.'</b></span> </center>
            </div>
        </div>
        <hr>
        ';
echo '<div style="margin: 20px;">';        
    foreach($reports as $rep){
        echo $rep->findings;
    }
}else{
    echo "No Results Found.";
}
echo '</div">';
    }

    public function search_patient(Request $request){

        //echo json_encode("testing");die();
        // echo json_encode($request->all());die();

        $kw = $request->q;
        if(empty($kw)){
             $members = DicomAllPatient::paginate(10);
            //$members = DicomAllPatient::Orderby('PatientID','DESC')->get()->take(20);
        }else{
            $members = DicomAllPatient::where('PatientNam', 'like' , "%{$kw}%")
                                ->paginate(10)
                                ->appends(['q'=> "{$kw}"])
                                ->withPath('/')
                                ->withQueryString();
        }
        //echo json_encode($members);die();
        $membersCollection = collect($members);
        $membersCollection = $membersCollection->merge(['pagination_links' => (string) $members->onEachSide(2)->links()]);
        return collect(["patients" => $membersCollection->all()])->toJson();
    }

}
