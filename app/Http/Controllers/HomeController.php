<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Prescription;
use App\Appointment;
use App\Billing;
use App\Billing_item;
use App;
use Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use mysqli;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
$user = Auth::user();
//return $user;

//$user->assignRole('admin');
//$user->syncRoles(['assistant']);

//$role = Role::create(['name' => 'admin']);
//1$role = Role::create(['name' => 'assistant']);

//$role = Role::findById(4); $role->givePermissionTo(Permission::all());

//$permission = Permission::create(['name' => 'manage roles']);

/*

$permission = Permission::create(['name' => 'view patient']);
$permission = Permission::create(['name' => 'view all patients']);
$permission = Permission::create(['name' => 'delete patient']);

$permission = Permission::create(['name' => 'create health history']);
$permission = Permission::create(['name' => 'delete health history']);

$permission = Permission::create(['name' => 'add medical files']);
$permission = Permission::create(['name' => 'delete medical files']);


$permission = Permission::create(['name' => 'create appointment']);
$permission = Permission::create(['name' => 'view all appointments']);
$permission = Permission::create(['name' => 'delete appointment']);

$permission = Permission::create(['name' => 'create prescription']);
$permission = Permission::create(['name' => 'view prescription']);
$permission = Permission::create(['name' => 'view all prescriptions']);
$permission = Permission::create(['name' => 'edit prescription']);
$permission = Permission::create(['name' => 'delete prescription']);
$permission = Permission::create(['name' => 'print prescription']);


$permission = Permission::create(['name' => 'create drug']);
$permission = Permission::create(['name' => 'edit drug']);
$permission = Permission::create(['name' => 'view drug']);
$permission = Permission::create(['name' => 'view all drugs']);

$permission = Permission::create(['name' => 'create diagnostic test']);
$permission = Permission::create(['name' => 'edit diagnostic test']);
$permission = Permission::create(['name' => 'view all diagnostic tests']);

$permission = Permission::create(['name' => 'create invoice']);
$permission = Permission::create(['name' => 'edit invoice']);
$permission = Permission::create(['name' => 'view invoice']);
$permission = Permission::create(['name' => 'view all invoices']);
$permission = Permission::create(['name' => 'delete invoice']);
        
*/

        $total_patients = User::where('role','patient')->count();
        $total_patients_today = User::where('role','patient')->wheredate('created_at', Today())->count();
        $total_appointments = Appointment::all()->count();
        $total_appointments_today = Appointment::wheredate('date', Today())->get();
        $total_prescriptions = Prescription::all()->count();
        $total_payments = Billing::all()->count();
        $total_payments = Billing::all()->count();
        $total_payments_month = Billing_item::whereMonth('created_at',date('m'))->sum('invoice_amount');
        $total_payments_month = Billing_item::whereMonth('created_at',date('m'))->sum('invoice_amount');
        $total_payments_year = Billing_item::whereYear('created_at',date('Y'))->sum('invoice_amount');
        return redirect()->route('patient.all');

        return view('home', [
            'total_patients' => $total_patients, 
            'total_prescriptions' => $total_prescriptions, 
            'total_patients_today' => $total_patients_today,
            'total_appointments' => $total_appointments,
            'total_appointments_today' => $total_appointments_today,
            'total_payments' => $total_payments,
            'total_payments_month' => $total_payments_month,
            'total_payments_year' => $total_payments_year
        ]);
    }


    public function lang($locale){

        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }


    public function our_backup_database(){

        // $servername = "localhost";
        // $username = "root";
        // $password = "";
        // $dbname = "hch";
        
        // // Create connection
        // $conn = new mysqli($servername, $username, $password, $dbname);
        
        // // Check connection
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        
        // // Open a file to write the backup
        // $backupFile = 'backup.sql';
        // $file = fopen($backupFile, 'w');
        // if (!$file) {
        //     die("Unable to open file for writing.");
        // }
        
        // // Function to get table creation SQL including foreign keys
        // function getTableCreateSQL($conn, $table) {
        //     $result = $conn->query("SHOW CREATE TABLE `$table`");
        //     $row = $result->fetch_assoc();
        //     return $row['Create Table'];
        // }
        
        // // Get a list of all tables
        // $tables = $conn->query("SHOW TABLES");
        // $tableList = [];
        // while ($row = $tables->fetch_row()) {
        //     $tableList[] = $row[0];
        // }
        
        // // Export schema
        // foreach ($tableList as $table) {
        //     $createTableSQL = getTableCreateSQL($conn, $table);
        //     fwrite($file, $createTableSQL . ";\n\n");
        // }
        
        // // Export data
        // foreach ($tableList as $table) {
        //     $result = $conn->query("SELECT * FROM `$table`");
        //     $numFields = $result->field_count;
            
        //     while ($row = $result->fetch_assoc()) {
        //         $columns = implode(", ", array_keys($row));
        //         $values = implode(", ", array_map(function($value) use ($conn) {
        //             return "'" . $conn->real_escape_string($value) . "'";
        //         }, $row));
                
        //         $sql = "INSERT INTO `$table` ($columns) VALUES ($values);\n";
        //         fwrite($file, $sql);
        //     }
        //     fwrite($file, "\n");
        // }
        
        // // Close the file
        // fclose($file);
        // $conn->close();
        // echo "Backup completed successfully.";
        
        
//  *******************************************

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

// ***********************************************

//}


//         $mysqlHostName      = env('DB_HOST');
//         $mysqlUserName      = env('DB_USERNAME');
//         $mysqlPassword      = env('DB_PASSWORD');
//         $DbName             = env('DB_DATABASE');
//         $backup_name        = "mybackup.sql";
//         $tables             = array("appointments","billings","users","billing_items","	doctors","documents","drugs","exams","failed_jobs","findings","findings_impressions","migrations","model_has_permissions","model_has_roles"
//         ,"password_resets","patients","permissions","prescriptions","prescription_drugs","prescription_tests","results","roles","role_has_permissions","settings","tests","users"); //here your tables...

//         $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword",array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
//         $get_all_table_query = "SHOW TABLES";
//         $statement = $connect->prepare($get_all_table_query);
//         $statement->execute();
//         $result = $statement->fetchAll();


//         $output = '';
//         foreach($tables as $table)
//         {
//          $show_table_query = "SHOW CREATE TABLE " . $table . "";
//          $statement = $connect->prepare($show_table_query);
//          $statement->execute();
//          $show_table_result = $statement->fetchAll();

//          foreach($show_table_result as $show_table_row)
//          {
//           $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
//          }
//          $select_query = "SELECT * FROM " . $table . "";
//          $statement = $connect->prepare($select_query);
//          $statement->execute();
//          $total_row = $statement->rowCount();

//          for($count=0; $count<$total_row; $count++)
//          {
//           $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
//           $table_column_array = array_keys($single_result);
//           $table_value_array = array_values($single_result);
//           $output .= "\nINSERT INTO $table (";
//           $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
//           $output .= "'" . implode("','", $table_value_array) . "');\n";
//          }
//         }
//         $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';
//         $file_handle = fopen($file_name, 'w+');
//         fwrite($file_handle, $output);
//         fclose($file_handle);
//         header('Content-Description: File Transfer');
//         header('Content-Type: application/octet-stream');
//         header('Content-Disposition: attachment; filename=' . basename($file_name));
//         header('Content-Transfer-Encoding: binary');
//         header('Expires: 0');
//         header('Cache-Control: must-revalidate');
//            header('Pragma: public');
//            header('Content-Length: ' . filesize($file_name));
//            ob_clean();
//            flush();
//            readfile($file_name);
//            unlink($file_name);
// return "success";

}


}
