<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;

use App\Test;
use App\Exam;

class TestController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    
    public function create(){
    	return view('test.create');
    }

    public function store(Request $request){

    		$validatedData = $request->validate([
	        	'test_name' => 'required',
	    	]);

    	$test = new Test;

        $test->test_name = $request->test_name;
        $test->comment = $request->comment;

        $test->save();
        $test_id =  $test->id;

        $rules = [];

        foreach($request->input('name') as $key => $value) {
            $rules["name.{$key}"] = 'required';
        }


            foreach($request->input('name') as $key => $value) {
                Exam::create(['name'=>$value,'test_id' => $test_id, 'range' => $value, 'unit' => $value, 'input' => $value,'short_code' => $value, 'content' => $value]);
            }
            $success = 'Test Created Successfully';
        return Redirect::route('test.all')->with('success', __('sentence.Test Created Successfully'));
      //  return view('test.all', ['success'=> $success]);

    }

    public function all(){
    	$tests = Test::all();
    	return view('test.all', ['tests' => $tests]);
    }

    public function edit($id){
        $test = Test::find($id);
        $exams = Exam::where('test_id' ,$id)->get();
    if(empty($exams)) $exams = '';
    
        return view('test.edit',['test' => $test, 'exams' => $exams]);
    }

    public function store_edit(Request $request){
            
            $validatedData = $request->validate([
                'test_name' => 'required',
            ]);
        
        $test = Test::find($request->test_id);

        $test->test_name = $request->test_name;
        $test->comment = $request->comment;

        $test->save();

        $test_id =  $test->id;
        Exam::where('test_id',$test_id)->delete();

        foreach($request->input('name') as $key => $value) {
            $rules["name.{$key}"] = 'required';
        }


        foreach($request->input('name') as $key => $value) {
            Exam::create(['name'=>$value,'test_id' => $test_id, 'range' => $value, 'unit' => $value, 'input' => $value,'short_code' => $value, 'content' => $value]);
        }
      return Redirect::route('test.all')->with('success', __('sentence.Test Edited Successfully'));

    }

    public function destroy($id){

    	Test::destroy($id);
        return Redirect::route('test.all')->with('success', __('sentence.Test Deleted Successfully'));

    }
}
