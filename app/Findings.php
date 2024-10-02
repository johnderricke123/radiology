<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Findings extends Model
{
    use HasFactory;

    protected $fillable = [
        'result_id',
        'findings',
        'test',        
        'impressions'
    ];
    public function result_id(){
        return $this->belongsTo('App\Result', 'id', 'result_id');
    }

    public function study_date($value)
        {
          // return  date(FROM_UNIXTIME(UNIX_TIMESTAMP($value, 'yyyy-mm-dd'))); 
            return date("Y-m-d", strtotime($value));
        }

        public function created_at($value)
        {
          // return  date(FROM_UNIXTIME(UNIX_TIMESTAMP($value, 'yyyy-mm-dd'))); 
            return date("Y-m-d", strtotime($value));
        }

        
}
