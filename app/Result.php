<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table = 'results';

    protected $fillable = ['patient_id',	
                'dicom_patient_id',	
                'exam_number',	
                'study_instance',
                'test_id',	
                'exam_id',
                'cs',
                'modality',
                'body_part',
                'refering_phys',
                'study_date',
                'series_desc',
                'series_num',
                'case_no',
                'plate_no',	
                'findings',
                'impressions',	
                'remarks',
                'physician_id',
                'created_by'];

    protected $dates = [
                    'created_at',
                    'study_date'
                ];

                
    public function Patient(){
                    return $this->hasOne('App\Patient', 'id', 'patient_id');
        }
        public function Physician(){
          return $this->hasOne('App\User', 'id', 'physician_id');
}
    
    public function FindingsImpression(){
            return $this->hasMany('App\FindingsImpressions','findingsimpressions');
    }

    public function Findings(){
        return $this->hasMany('App\Findings','id','result_id');
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

