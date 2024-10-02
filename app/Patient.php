<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    // protected $fillable = [
    //     'birthday',
    //     'first_name',
    //     'last_name',        
    //     'middle_name',     
    //     'phone',     
    //     'gender',     
    //     'blood',     
    //     'adress',     
    //     'weight',     
    //     'height',     
    // ];

	protected $table = 'patients';


	public function Result(){
        return $this->hasMany('App\Result');
    }

}
