<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exams';  //table from your database
    protected $primaryKey = 'id';


    protected $fillable = [
        'name',
        'content',
        'range',
        'result',
        'unit',
        'input_type',
        'short_code',
        'test_id'
    ];


//    public function Test(){
//        return $this->belongsToMany('App\Test','Test');
//    }
    public function Test(){
        return $this->hasOne('App\Test', 'id', 'test_id');
    }
}
