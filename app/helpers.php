<?php

use App\Result;
use Illuminate\Support\Facades\DB;

function check_for_reports($results){
    //var_dump("testing1");die();

// *******************************CODE FOR DISABLING MAKE REPORT BUTTON WHEN REPORT IS ALREADY GENERATED************************
$i = 0;
foreach($results as $res){
    // Assuming $res is an object
    $checking = Result::where('study_instance', $res->StudyInsta)->get();
    
    // Check if the collection is not empty
    if($checking->isNotEmpty()){
        $res->hasReport = 1;
    } else {
// ***************************
    // $check_mods = DB::connection('sqlite_second')
    // ->table('UIDMODS')
    // ->where('NewUID', $res->StudyInsta)
    // ->select('UIDMODS.NewUID')
    // ->get();

    $check_mods = DB::connection('sqlite_second')
    ->table('UIDMODS')
    ->where('NewUID', $res->StudyInsta)
    ->select('UIDMODS.OldUID')
    ->get();

        // if($check_mods->isNotEmpty()){
        //     $checking2nd = Result::where('study_instance', $check_mods[0]->NewUID)->get();
        //     if($checking2nd->isNotEmpty()){
        //         $res->hasReport = 1;
        //     }
        // }else{
        //     $res->hasReport = 0;
        // }

        if($check_mods->isNotEmpty()){
        
            $checking2nd = Result::where('study_instance', $check_mods[0]->OldUID)->get();
            //var_dump("test");die();
            if($checking2nd->isNotEmpty()){
                $res->hasReport = 1;
            }else{
                $res->hasReport = 0;
            }
        }else{
            $res->hasReport = 0;
        }
// ***************************
    }
    $i++;
}
return $results;
// *******************************CODE FOR DISABLING MAKE REPORT BUTTON WHEN REPORT IS ALREADY GENERATED************************
} 

