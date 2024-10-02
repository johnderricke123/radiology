<?php

namespace App;

use App\Traits\FilterableByDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DicomServer extends Model
{
    use HasFactory, FilterableByDates;
    protected $connection = 'sqlite_second';
    protected $table = 'DICOMStudies';

    protected $likeFilterFields = ['studyDate','StudyModal','PatientSex'];

    public function studyDate($value)
        {
          // return  date(FROM_UNIXTIME(UNIX_TIMESTAMP($value, 'yyyy-mm-dd'))); 
            return date("Y-m-d", strtotime($value));
        }

        
}
