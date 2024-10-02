<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
        protected $table = 'tests';


        public function Prescription(){
                return $this->hasMany('App\Prescription_test');
        }
    public function Exam(){
        return $this->hasMany('App\Exam');
    }
}
