<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Result;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function our_backup_database(){
        /**
        * Updated: Mohammad M. AlBanna
        * Website: MBanna.info
        */
        
        
        //MySQL server and database
        $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'hch';
        $tables = '*';
        
        //Call the core function
        //backup_tables($dbhost, $dbuser, $dbpass, $dbname, $tables);
        
        //Core function
        $host = $dbhost;
        $user = $dbuser;
        $pass = $dbpass;
        // function backup_tables($host, $user, $pass, $dbname, $tables = '*') {
            $link = mysqli_connect($host,$user,$pass, $dbname);
        
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                exit;
            }
        
            mysqli_query($link, "SET NAMES 'utf8'");
        
            //get all of the tables
            if($tables == '*')
            {
                $tables = array();
                $result = mysqli_query($link, 'SHOW TABLES');
                while($row = mysqli_fetch_row($result))
                {
                    $tables[] = $row[0];
                }
            }
            else
            {
                $tables = is_array($tables) ? $tables : explode(',',$tables);
            }
        
            $return = '';
            //cycle through
            foreach($tables as $table)
            {
                $result = mysqli_query($link, 'SELECT * FROM '.$table);
                $num_fields = mysqli_num_fields($result);
                $num_rows = mysqli_num_rows($result);
        
                $return.= 'DROP TABLE IF EXISTS '.$table.';';
                $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
                $return.= "\n\n".$row2[1].";\n\n";
                $counter = 1;
        
                //Over tables
                for ($i = 0; $i < $num_fields; $i++) 
                {   //Over rows
                    while($row = mysqli_fetch_row($result))
                    {   
                        if($counter == 1){
                            $return.= 'INSERT INTO '.$table.' VALUES(';
                        } else{
                            $return.= '(';
                        }
        
                        //Over fields
                        for($j=0; $j<$num_fields; $j++) 
                        {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = str_replace("\n","\\n",$row[$j]);
                            if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                            if ($j<($num_fields-1)) { $return.= ','; }
                        }
        
                        if($num_rows == $counter){
                            $return.= ");\n";
                        } else{
                            $return.= "),\n";
                        }
                        ++$counter;
                    }
                }
                $return.="\n\n\n";
            }
        
            //save file
            $fileName = 'dbBackup/db-backup-'.date('y-m-d H-i-s').'-'.(md5(implode(',',$tables))).'.sql';
            $handle = fopen($fileName,'w+');
            fwrite($handle,$return);
            if(fclose($handle)){
                echo "Done, the file name is: ".$fileName;
                exit; 
            }
        
        }

        public function testing(){
            return view('dicom.test');
        }
        public function getData(){
             $results = Result::all();
            return response()->json($results);
            //return response()->json("testing");
        }
}
