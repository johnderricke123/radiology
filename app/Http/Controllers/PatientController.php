<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Patient;
use App\Prescription;
use App\Appointment;
use App\Billing;
use App\DicomAllPatient;
use App\Document;
use App\History;
use App\Result;

use Hash;
use Redirect;
use Str;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }


    public function all(){

    	//$patients = User::where('role', '=' ,'patient')->OrderBy('id','DESC')->paginate(10);
    	// $patients = Patient::OrderBy('name','ASC')->paginate(10);
		$patients = Patient::OrderBy('created_at','DESC')->OrderBy('name','ASC')->get();

    	return response()->view('patient.all', ['patients' => $patients])->header('X-Frame-Options', 'http://localhost:5000');

    }

	public function search(Request $request){
    	
    	$term = $request->term;

    	// $patients = User::where('name','LIKE','%' . $term . '%')->OrderBy('id','DESC')->paginate(10);
		$patients = Patient::where('name', 'like', "%$term%")
		->orWhere('first_name', 'like', "%$term%")
		->OrderBy('name','ASC')->get();


		return response()->view('patient.all', ['patients' => $patients])->header('X-Frame-Options', 'http://localhost:5000');
    	//return view('patient.all', ['patients' => $patients]);
    }

    public function create($id=null){
		if(!empty($id)){
			$patientInfo = DicomAllPatient::where('PatientID',$id)->first();
			$patientname = explode('^', $patientInfo->PatientNam);
			$patientInfo['lastName'] = $patientname[0];
			$patientInfo['firstName'] = $patientname[1]; 
			//var_dump($patientname);die();
		}else{
			$patientInfo = null;
		}
		return view('patient.create', ['patientInfo' => $patientInfo]);
    }



    public function store(Request $request){
		//var_dump("testing");die();
    	$validatedData = $request->validate([
        	'name' => ['required', 'string', 'max:255'],
          //  'email' => ['string', 'email', 'max:255', 'unique:users,email'],
            'birthday' => ['required','before:today'],
            'blood' => ['required',
            			Rule::in(['Unknown', 'A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
        	],
            'gender' => ['required',
            			Rule::in(['Male', 'Female']),
        				],
            'weight' => ['numeric','nullable'],
            'height' => ['numeric','nullable'],
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:5048',

    	]);

    	// $user = new User();
		// $user->password = Hash::make('admin123');
		// $user->email = $request->email;
		// $user->name = $request->name;

		// if($request->hasFile('image')){

		// 	// We Get the image
		//  	$file = $request->file('image'); 
		//  	// We Add String to Image name 
        //     $fileName = Str::random(15).'-'.$file->getClientOriginalName();
        //     // We Tell him the uploads path 
        //     $destinationPath = public_path().'/uploads/';
        //     // We move the image to the destination path
        //     $file->move($destinationPath,$fileName);
        //     // Add fileName to database 
            
        // 	$user->image = $fileName;
		// }else{
		// 	$user->image = "";
		// }
			

		// $user->save();


		$patient = new Patient();

		//$patient->user_id = $user->id;
		$patient->birthday = $request->birthday;
		$patient->name = $request->name;
		$patient->middle_name = $request->middle_name;
		$patient->first_name = $request->first_name;
		$patient->gender = $request->gender;
		$patient->blood = $request->blood;
		$patient->adress = $request->adress;
		$patient->weight = $request->weight;
		$patient->height = $request->height;
		$patient->dicom_patient_id = $request->dicomID;
		$patient->save();

		return Redirect::route('patient.all')->with('success', __('sentence.Patient Created Successfully'));
		
		}

    

	    public function edit($id){

	    	$patient = Patient::findOrfail($id);
			//return $patient;
	    	return view('patient.edit',['patient' => $patient]);

	    }

        public function store_edit(Request $request){
//return $request->all();
    		$validatedData = $request->validate([
	        	'name' => ['required', 'string', 'max:255'],
	            
            // 'birthday' => ['required','before:today'],
            'blood' => ['required',
            			Rule::in(['Unknown', 'A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
        	],
            'gender' => ['required',
            			Rule::in(['M', 'F']),
        				],
            'weight' => ['numeric','nullable'],
            'height' => ['numeric','nullable'],
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:5048',
    	]);

    	// $user = User::find($request->user_id);

		// $user->email = $request->email;
		// $user->name = $request->name;

		// if($request->hasFile('image')) {

		// 	// We Get the image
		//  	$file = $request->file('image'); 
		//  	// We Add String to Image name 
        //     $fileName = Str::random(15).'-'.$file->getClientOriginalName();
        //     // We Tell him the uploads path 
        //     $destinationPath = public_path().'/uploads/';
        //     // We move the image to the destination path
        //     $moved = $file->move($destinationPath,$fileName);
        //     // Add fileName to database 

        //     $fullpath = public_path().'/uploads/'.$user->image;

        //     if($moved && !empty($user->image)){
        //     	unlink($fullpath);
        //     }

        // 	$user->image = $fileName;

		// }
			

		// $user->update();

//var_dump($request->name);die();
		$patient = Patient::where('id', '=' , $request->id)
		         			->update(['birthday' => $request->birthday,
										'first_name' => $request->first_name,
										'name' => $request->name,
										'middle_name' => $request->middle_name,
										'phone' => $request->phone,
										'gender' => $request->gender,
										'blood' => $request->blood,
										'adress' => $request->adress,
										'weight' => $request->weight,
										'height' => $request->height]);
if($patient){
	return Redirect::back()->with('success', __('sentence.Patient Updated Successfully'));
}else{
	return Redirect::back()->with('error', __('sentence.Patient Update unsuccessfully'));
}
		

    }


    public function view(Request $request, $id){

		// $clientIP = request()->ip();
		// dd($clientIP);
		// die();

    	$patient = Patient::findOrfail($id);
        $prescriptions = Prescription::where('id' ,$id)->OrderBy('id','Desc')->get();
        $appointments = Appointment::where('id' ,$id)->OrderBy('id','Desc')->get();
        $documents = Document::where('id' ,$id)->OrderBy('id','Desc')->get();
        $invoices = Billing::where('id' ,$id)->OrderBy('id','Desc')->get();
        $historys = History::where('id' ,$id)->OrderBy('id','Desc')->get();
		$dicom = Result::where('patient_id' ,$id)->OrderBy('id','Desc')->get();
		
		// $clientIp = $request->ip();
		// echo  $clientIp;die();


//return $dicom;
    	return view('patient.view', [
    		'patient' => $patient, 
    		'prescriptions' => $prescriptions, 
    		'appointments' => $appointments, 
    		'invoices' => $invoices,
    		'documents' => $documents,
    		'historys' => $historys,
			'dicom'=> $dicom
    	]);

    }





    public function destroy($id){

    	$patient = Patient::destroy($id);

    	return Redirect::back()->with('success', 'Patient Deleted Successfully');
    }


}
