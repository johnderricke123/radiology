<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Result;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Patient;
use App\Setting;
use App\User;
use App\Findings;
use Hash;
use Carbon\Carbon;

class ResultController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $id = null)
    {
        // return $id;
        // return $request->study_instance;

        //$newlyInsertedId = $result->id;
// $results = DB::connection('sqlite_second')
//         ->table('DICOMStudies')
//         ->where('StudyInsta', $request->study_instance)
//         ->update(['hasReport' => "1"]);
//return $results;

            $patient_id = Patient::where('dicom_patient_id', $request->dicom_patient_id)->get();
            
            if(isset($patient_id[0]->dicom_patient_id)) {
                $patient_id = $patient_id[0]->id;
            } else {
            $patient = new Patient();
            $patient->name = $request->name;
            $patient->first_name = $request->first_name;
            // $patient->middle_name = $request->middle_name;
            $patient->birthday = date("M d Y", strtotime($request->birthday));
            $patient->phone = $request->phone;
            $patient->gender = $request->sex;
            $patient->blood = $request->blood;
            $patient->adress = $request->adress;
            $patient->weight = $request->weight;
            $patient->height = $request->height;
            $patient->dicom_patient_id = $request->dicom_patient_id;
    
            $patient->save();
            $patient_id = $patient->id;
            }

            $user_logged = Auth::user();
          
            
            if(isset($request->id) && isset($request->update_patient_id)) // IF for Update
            {
             
            $patient = Patient::where('dicom_patient_id', $request->dicom_patient_id)->get();
              $result = Result::find($request->id);
              $result->update(array_merge($request->all(), ['created_by' => $user_logged->id]));

                 $findings = Findings::where('result_id','=', $request->id)
                        ->update([
                        'findings' =>  nl2br($request->findings)                        
                 ]); 
                 $patients = Patient::OrderBy('name','ASC')->paginate(10);
                // $results = DB::connection('sqlite_second')->table('DICOMStudies')->take(20)->get();

                 $results = DB::connection('sqlite_second')->table('DICOMStudies')
     ->orderBy('StudyDate','DESC')->take(50)->get();

                 return response()->view('dicom.all', ['patients' => $patients,'results' => $results]);
                // return view('result.view',['result' => $result, 'patient' => $patient, 'findings' => $findings]);
             
            } else {   // For NEW Create Result
                
                $result = Result::create([               
                    'patient_id' => $patient_id,	
                    'dicom_patient_id' => $request->dicom_patient_id,	
                    'exam_number' => $request->exam_number,	
                    'study_instance' => $request->study_instance,
                    'test_id' => 1,	
                    'modality' => $request->modality,
                    'cs' => $request->cs,
                    'case_no' => $request->caseNumber,
                    'plate_no' => $request->plateNumber,
                    'body_part' => $request->body_part,
                    'series_num'=> $request->series_num,
                    'exam_id' => 4,	
                    // 'refering_phys' => $request->ReferPhys,
                    'refering_phys' => $request->physician_id,
                    'remarks' => $request->remarks,
                    'created_by'=> $user_logged->id,
                    'study_date' => $request->study_date,
                    'physician_id' => $request->physician_id
                ]);
            
                $i = 0;
              
                    $findings_db = new Findings();

                    $findings_db->result_id     = $result->id;
                    // $findings_db->test          = $test;
                    $findings_db->findings      =  nl2br($request->findings);
//var_dump($result->id);die();
                    $save = $findings_db->save();
            
              

            $success = 'Result Created Successfully';
            }

            $newlyInsertedId = $result->id;
            $request->study_instance;
            $results = DB::connection('sqlite_second')
                ->table('DICOMStudies')
                ->where('StudyInsta', $request->study_instance)
                ->update(['hasReport' => $newlyInsertedId]);
    
            //return redirect('/patient/print/report/'.$newlyInsertedId);

            $results = DB::connection('sqlite_second')->table('DICOMStudies')->take(20)->get();
    //var_dump($newlyInsertedId);die();
            return redirect()->route('dicom.patient.view', ['id' => $request->dicom_patient_id, 'study_insta' => $request->study_instance, 'reportId' => $newlyInsertedId]);

            //$request->study_instance

            // return view('dicom.all', [
            //     'reportId' => $newlyInsertedId,
            //     'results' => $results
            // ])->with('success', __('sentence.Result Created Successfully'));;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        
    	$result = Result::findOrfail($id);
       
        $findings = Findings::where('result_id', $result->id)->get();
       
        $setting = Setting::all();
       
        
        $patient = Patient::where('id',$result->patient_id)->get();
        $physician ='';
        if($result->refering_phys){
        $physician = User::where('title','=',$result->refering_phys)->first();
        }
       
    	return view('result.view',['result' => $result, 'patient' => $patient, 'findings' => $findings,'physician'=> $physician]);
   
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
        $result = Result::destroy($id);

    	return Redirect::back()->with('success', 'Result Deleted Successfully');
    }

    public function all_reports(Request $request){

        $monday = strtotime('last monday', strtotime('tomorrow'));
        $sunday = strtotime('+6 days', $monday);
        $date1 = date('Ymd', $monday);
        $date2 = date('Ymd', $sunday);

        
        //$result = Result::all();

        // $result = DB::table('results')
        //     ->join('patients', 'patients.id', '=', 'results.patient_id')
        //     ->join('users', 'users.id', '=', 'results.created_by')
        //     ->select('results.*', 'results.id as result_id', 'patients.first_name as patient_fname',
        //     'patients.name as patient_lname','patients.gender as patient_gender'
        //     ,'users.name as creator','users.first_name as creator_fname','users.middle_name as creator_mname')
        //     ->orderBy('results.created_at', 'desc')
        //     ->orderBy('patients.last_name', 'asc')
        //     ->get();



$date_filter = explode(" - ",$request->input('date_filter'));
        //return $date_filter;
if ($request->input('date_filter')) {
       $date1 = str_replace("-","",$date_filter[0]);
       $date2 = str_replace("-","",$date_filter[1]);
}
$result = DB::table('results')
    ->join('patients', 'patients.id', '=', 'results.patient_id')
    ->join('users', 'users.id', '=', 'results.created_by');

if ($request->input('date_filter')) {
    // $date1 = $request->input('date_filter_from'); // Adjust to your actual input names
    // $date2 = $request->input('date_filter_to');   // Adjust to your actual input names
    $result->whereBetween('results.created_at', [$date1, $date2]);
}

$result = $result->select(
        'results.*', 
        'results.id as result_id', 
        'patients.first_name as patient_fname',
        'patients.name as patient_lname',
        'patients.gender as patient_gender',
        'users.name as creator',
        'users.first_name as creator_fname',
        'users.middle_name as creator_mname'
    )
    ->orderBy('results.created_at', 'desc')
    ->orderBy('patients.last_name', 'asc')
    ->get();


//return $result;


/***********************
            if($request->has('date_filter')){

                $date_filter = explode(" - ",$request->input('date_filter'));
                //return $date_filter;
               $date1 = str_replace("-","",$date_filter[0]);
               $date2 = str_replace("-","",$date_filter[1]);
                //    $results = Result::whereBetween('created_at', [$date1, $date2])
                //        ->orderBy('created_at','DESC')->get();


//TESTING
                $results = DB::table('results')
                ->join('patients', 'patients.id', '=', 'results.patient_id')
                ->join('users', 'users.id', '=', 'results.created_by')
                ->whereBetween('results.created_at', [$date1, $date2])
                ->select('results.*', 'results.id as result_id', 'patients.first_name as patient_fname',
                'patients.name as patient_lname','patients.gender as patient_gender'
                ,'users.name as creator','users.first_name as creator_fname','users.middle_name as creator_mname')
                ->orderBy('results.created_at', 'desc')
                ->orderBy('patients.last_name', 'asc')
                ->get();
//TESTING
               }
      
               else{
                //   $results = Result::all();
                $result = DB::table('results')
                    ->join('patients', 'patients.id', '=', 'results.patient_id')
                    ->join('users', 'users.id', '=', 'results.created_by')
                    ->select('results.*', 'results.id as result_id', 'patients.first_name as patient_fname',
                    'patients.name as patient_lname','patients.gender as patient_gender'
                    ,'users.name as creator','users.first_name as creator_fname','users.middle_name as creator_mname')
                    ->orderBy('results.created_at', 'desc')
                    ->orderBy('patients.last_name', 'asc')
                    ->get();
                  
              }  
            //   else {
            //       $results = Result::whereBetween('created_at', [$date1, $date2])
            //       ->orderBy('created_at','ASC')->get();
            //    }
         
    //return $result;

***********************/
        return view('result.all',['result' => $result]);
    }
}
