<?php

namespace App;

use App\Traits\FilterableByDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class DicomAllPatient extends Model
{
    use HasFactory;
    //use FilterableByDates;
    protected $connection = 'sqlite_second';
    //protected $table = 'DICOMStudies';
    protected $table = 'DICOMPatients';
    protected $fillable = ['PatientID', 'PatientNam', 'PatientBir', 'PatientSex', 'AccessTime', 'qTimeStamp', 'qFlags', 'qSpare'];
    //protected $likeFilterFields = ['PatientID','StudyDate','StudyModal','PatientSex','StudyInsta'];
    //     protected $attributes = ['StudyTime' => null ];
    //     protected $appends = [
    //       'study_time'
    //   ];

   protected  $primaryKey = 'PatientID';
  
/*
    public function studyDate($value)
        {
            return date("Y-m-d", strtotime($value));
        }
*/
/*
    public function getStudyTimeAttribute($value)
    {
      
      $date = \Carbon\Carbon::parse($this->StudyDate)->format('Y-m-d');
      $study_time = explode('.',$value);
      $date_time = \Carbon\Carbon::createFromFormat('His', $study_time[0], 'Asia/Manila')->format('H:i:s'); // \Carbon\Carbon::parse($hours.":". $minutes.":".$seconds)->format('H:i:s');
      
      $time = \Carbon\Carbon::parse($date .' '.$date_time)->format('Y-m-d h:i:s A');
      if(Carbon::now()->startOfDay()->gte($time)){
          $time = \Carbon\Carbon::parse($time)->format('H:i:s'); // Kani if one day na time na ang gamit
      } else {
          $time =  \Carbon\Carbon::parse($time)->shortRelativeDiffForHumans(); // MAo ni CYA ang HUman  readable..
      }
    
        return $time;
    }
*/

        
}
