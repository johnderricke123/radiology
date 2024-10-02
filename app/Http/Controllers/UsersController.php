<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Patient;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;
use Redirect;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function all(){
        $users = User::orderBy('name','ASC')->paginate(500);
        return view('user.all', ['users' => $users]);
    }

    public function create(){
        $roles = Role::all()->pluck('name');
        return view('user.create',['roles' => $roles]);
    }

    public function store(Request $request){

        

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);

        $user = new User();
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->title = $request->title;
        $user->position = $request->position;
        $user->role = $request->role;
        $user->gender =  $request->gender;
        $user->save();

        if($request->hasFile('image')){

			// We Get the image
		 	$file = $request->file('image'); 
		 	// We Add String to Image name 
            $fileName = Str::random(15).'-'.$file->getClientOriginalName();
            // We Tell him the uploads path 
            $destinationPath = public_path().'/uploads/';
            // We move the image to the destination path
            $file->move($destinationPath,$fileName);
            // Add fileName to database 
        	$user->image = $fileName;
		}else{
			$user->image = "";
		}
	
		$user->save();


        $user->assignRole($request->role);

        return Redirect::route('user.all')->with('success', __('sentence.User Created Successfully'));

    }

    public function edit($id){
        $user = User::findorfail($id);
        $roles = Role::all()->pluck('name');
        return view('user.edit',['user' => $user,'roles' => $roles]);
    }

    public function edit_profile(){
        $user = Auth::user();
        $roles = Role::all()->pluck('name');
        return view('user.edit',['user' => $user,'roles' => $roles]);
    }

    public function store_edit(Request $request){
//var_dump($request->role);die();
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                    'required', 'email', 'max:255',
                    Rule::unique('users')->ignore($request->user_id),
            ],

        ]);

        $user = User::findorfail($request->user_id);
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->title = $request->title;
        $user->position = $request->position;
        // $user->role = $request->role;
        $user->gender =  $request->gender;
        $user->update();

        if($request->hasFile('image')){

			// We Get the image
		 	$file = $request->file('image'); 
		 	// We Add String to Image name 
            $fileName = Str::random(15).'-'.$file->getClientOriginalName();
            // We Tell him the uploads path 
            $destinationPath = public_path().'/uploads/';
            // We move the image to the destination path
            $file->move($destinationPath,$fileName);
            // Add fileName to database 
            
        	$user->image = $fileName;
		}else{
			$user->image = "";
		}
        $user->update();
   
        if(!empty($request->role)):
            $count_admins = User::role('admin')->count();
            if($count_admins == 1 && $user->hasRole('admin') == 1 && $request->role != "admin"){
                return Redirect::route('user.all')->with('warning', __('You Cannot delete the only existant admin'));
            }
            $user->syncRoles($request->role);
        endif;

        return Redirect::route('user.all')->with('success', __('sentence.User Updated Successfully'));

    }
}
