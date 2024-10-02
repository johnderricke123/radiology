@extends('layouts.master')

@section('title')
{{ 'Dicom List'}}
@endsection

@section('content')
<?php //use Carbon\Carbon; ?>
<!-- ****************SWEETALERT**************** -->
<script src="{{ asset('npm/sweetalert2@11.js') }}"></script>
@if (isset($success))
<script>
    Swal.fire({
            title: "Do you want to Print the Report?",
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: "Print",
            // denyButtonText: `Don't save`
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.open('/patient/print/report/'+<?php echo $reportId; ?>, '_blank').focus();
                return;
                //Swal.fire("Saved!", "", "success");
            }
            else if (result.isDenied) {
                Swal.fire("Canceled", "", "info");
                return;
            }
            });

</script>
@endif
<!-- ****************SWEETALERT**************** -->
<?php
//echo json_encode($results); 
echo \Carbon\Carbon::parse('171100.256')->format('g:i A')
?>
    <div class="card shadow mb-4">
            <div class="card-header py-3">
               <div class="row">
                    <div class="col-3">
                        <h6 class="m-0 font-weight-bold text-primary w-75 p-2"><img class="fa fa-grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /> All DICOM Studies</h6>
                    </div>
                    <div class="col-6">
                    <form action="{{ route('dicom.patient.all')}}" method="get">
                        <!-- <div class="form-group row"> -->
                            <div class="input-group p-2">
                                <input type="text" class="form-control" name="date_filter" id="date_filter"/>
                                <div class="input-group-append"> <input type="submit" name="filter_submit" class="btn btn-success" value="Filter" /></div>
                                <div class="input-group-append"> <a href="{{ route('dicom.patient.all','filter=All') }} " class="btn btn-info">All</a></div>
                                <div class="input-group-append"> <a href="{{ route('dicom.patient.all') }} " class="btn btn-warning">Clear</a></div>
                            
                            </div>
                            <!-- </div> -->
                        </form>
                    </div>
                    <div class="col-3">
                        <form method="post" action="{{ route('search.dicom.patient') }}">
                            @csrf
                            <div class="input-group p-2">
                                    <input type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" name="nameOrPatientId" class="form-control text-right shadow p-3 bg-white border-0 small navbar-search">
                                    <div class="input-group-append"><button type="submit" class="btn btn-primary text-right"><i class="fas fa-search fa-sm"></i></button></div>
                            </div>
                        </form>
                    </div>
<!-- **************************** -->

<!-- ***************************** -->
              </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table stripe row-border" id="dataTable" cellspacing="0">
                        <thead>
                            <tr>
                            <th>Study Date</th>
                                <th>Patient ID</th>
                                <th>Patient Name</th>
                                <th class="text-center">Modality</th>
                                <th class="text-center">Gender</th>
                                <th class="text-center">Referring Physician</th>
                                <th width="15%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php
                            
                             foreach ($results as $result) : ?>
                                <tr><?php

                                $result_date =  $result->StudyDate;
                                $result_date = preg_replace('/(?<=^\d{4}|^\d{6})(?=\d)/i', '-', $result_date);

                              $patient_name = preg_replace("~^~","",$result->PatientNam, 10);
                             //   $patient_name = $result->PatientNam;

// DATE TIME CONVERSION
// $studyDate = ""; $year = ""; $month = ""; $day = ""; $timeString = ""; $hours = "";
// $minutes = ""; $seconds = ""; $milliseconds = ""; $carbonTime = ""; $readableTime = ""; $converted = "";
// $date = DB::connection('sqlite_second')
// ->table('DICOMStudies')
// ->where('StudyInsta', $result->StudyInsta)
// ->select('DICOMStudies.StudyTime', 'DICOMStudies.StudyDate')
// ->first();

// $studyDate = $date->StudyDate;
// $year= substr($studyDate, 0, 4);
// $month= substr($studyDate, 4, 2);
// $day= substr($studyDate, 6, 2);
// $studyDate = $year."-".$month."-".$day." ";

// $timeString = $date->StudyTime;
// $hours = substr($timeString, 0, 2);
// $minutes = substr($timeString, 2, 2);
// $seconds = substr($timeString, 4, 2);
// $milliseconds = substr($timeString, 7, 3); 

// $carbonTime = Carbon::createFromFormat('H:i:s', "$hours:$minutes:$seconds");
// $readableTime = $carbonTime->format('H:i:s');
// $converted = $studyDate.$readableTime;
// DATE TIME CONVERSION


// $timeString = $result->StudyTime;

// $hours = substr($timeString, 0, 2);
// $minutes = substr($timeString, 2, 2);
// $seconds = substr($timeString, 4, 2);

// $carbonTime = Carbon::createFromTime((int)$hours, (int)$minutes, (int)$seconds);

// $formattedTime12Hour = $carbonTime->format('g:i A');


                                ?>
                                <td><label class="badge badge-primary-soft">
                                    {{ \Carbon\Carbon::parse($result->StudyDate)->format('M d Y') }} 
                                    {{ \Carbon\Carbon::parse($result->StudyTime)->format('H:i') }}
                                </label></td>
                                <!-- <td><label class="badge badge-primary-soft">
                                  
                                </label></td> -->
                                
                                    <td> <?php echo $result->PatientID; ?> </td>
                                    <td><a href="{{ route('patient.create', ['id' => $result->PatientID]) }}">{{ $str = preg_replace('/[^A-Za-z0-9. -]/', ', ', $patient_name ) }}</a></td>
                                    <td class="text-center"> <?php
                                    //echo date("M d Y", strtotime($result->PatientBir));
                                    echo $result->StudyModal ?> </td>
                                    <td class="text-center"> <?php echo $result->PatientSex; ?> </td>
                                    <td class="text-center"> <?php echo $result->ReferPhysi; ?> </td>

                                    <td class="text-center"> 
                                            <div claas="row" style="display:inline-flex;">
                                            @if(Auth::user()->can('create appointment'))
                                                    <form method="get" action="/view/dicom/patient/{{$result->PatientID}}">
                                                        <!-- <a href="/view/dicom/patient/{{$result->PatientID}}" class="btn btn-outline-success btn-sm"><i class="fa fa-edit"></i></a> -->
                                                        <input type="hidden" name="study_insta" value="{{$result->StudyInsta}}"/>
                                                        <button  type="submit" class="btn btn-outline-success btn-sm"><i class="fa fa-edit"></i></button>
                                                    </form>
                                                    
                                            @endif
                                                        <!-- <a class="btn btn-outline-primary btn-sm text-secondary" title="Enter Result" data-toggle="modal" id="mediumButton" data-target="#mediumModal"
                                                            data-attr="{{$result->PatientID}}">
                                                            <i class="fas fa-edit text-gray-300"></i>
                                                        </a> -->
                                                        <!-- <a class="btn btn-outline-primary btn-sm" onclick='window.open("http://xray.hchdgte.com/viewer?StudyInstanceUIDs={{ $result->StudyInsta }}",  "_blank", "width=1220, height=1200", "class=btn btn-outline-warning btn-sm", "title=View Study");' ><img class="fa grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /> </a> -->
<!-- <a class="btn btn-outline-primary btn-sm" onclick='window.open("http://www.hchdgte.com/viewer?StudyInstanceUIDs={{ $result->StudyInsta }}",  "_blank", "width=1020, height=1200", "class=btn btn-outline-warning btn-sm", "title=View Study");' ><img class="fa grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /> </a> -->
<!-- *********************TEMPORARY FIXED********************* -->
                                @if(request()->getHost() == "localhost:8000")
                                  <a class="btn btn-outline-secondary btn-sm" title="View Dicom" onclick='window.open("https://www.hchdgte.com/viewer?StudyInstanceUIDs={{ $result->StudyInsta }}",  "_blank", "width=720, height=1200", "class=btn btn-outline-warning btn-sm", "title=View Study");' ><img class="fa fa-grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /> </a>
                                @endif
                                @if(request()->getHost() != "xray.hchdgte.com")
                                    <?php //echo "IP Address of client " . getenv("REMOTE_ADDR");  ?>
                                    @if(getenv("REMOTE_ADDR") == "192.168.254.157")
                                    <a class="btn btn-outline-secondary btn-sm" title="View Dicom" onclick='window.open("https://www.hchdgte.com/viewer?StudyInstanceUIDs={{ $result->StudyInsta }}",  "_blank", "width=720, height=1200", "class=btn btn-outline-warning btn-sm", "title=View Study");' ><img class="fa grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /> </a>
                                    @endif
                                    @if(getenv("REMOTE_ADDR") != "192.168.254.157")
                                    <a href="http://localhost:5000/viewer?StudyInstanceUIDs={{ $result->StudyInsta }}" target="_blank" class="btn btn-outline-secondary btn-sm" title="View Dicom" ><img class="fa grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /> </a>
                                    @endif
                                @endif
                                @if(Auth::user()->can('create appointment'))
                                  <a href="/download/dicom/folder/{{$result->PatientID}}" title="Download Dicom" class="btn btn-outline-warning btn-circle btn-sm"><i class="fa fa-download" aria-hidden="true"></i></a>                                
                                @endif

<!-- <a href="/view/dcm/file/{{$result->PatientID}}/{{ $result->StudyInsta }}" class="btn btn-sm btn-primary">test</a> -->

<a class="btn btn-outline-secondary btn-sm" title="View Dicom" onclick='openPopup("<?php echo $result->StudyInsta; ?>",<?php echo $result->PatientID; ?>)' ><img class="fa grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" />te </a>
<a onclick='window.open("/view/dcm/file/{{$result->PatientID}}/{{ $result->StudyInsta }}",  "_blank", "width=720, height=1200", "class=btn btn-outline-warning btn-sm", "title=View Study");' class="btn btn-outline-secondary btn-sm"> <img class="fa grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" />12 </a>

<?php
if($result->hasReport == "1"){
echo "1";
}
if($result->hasReport == "0"){
    echo "0";
}
?>
<!-- *********************TEMPORARY FIXED********************* -->

                                            </div>
        
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <span class="float-right mt-3"></span>
            </div>
    </div>

    <!-- <p id="title">Original Title</p>
<small>Because Stack Snippets don't have &lt;title> support, I used a p element there. In real development, replace &lt;p> with &lt;title>.</small> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <!-- Include Required Prerequisites -->
    <!-- <script src="code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script> -->


        
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js" defer></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>

    <script type="text/javascript">
  new DataTable('#dataTable');

</script>
<script>
// setInterval(function() {
//   var title = document.getElementById('title');
//   if (title.innerHTML === "Original Title") {
//     title.innerHTML = "New Notification!";
//   } else {
//     title.innerHTML = "Original Title";
//   }
// },1000)

// function openPopup(study_instance, patientId) {
//     var i = 0;
//     i = i + 1;
//     const width = 400;
//     const height = 300;
//     const left = 100 + (i * 50);
//     const top = 100; 

//     const screenWidth = window.innerWidth;
//     const screenHeight = window.innerHeight;

//     const halfWidth = Math.floor(screenWidth / 2);
//     const halfHeight = Math.floor(screenHeight / 2);

// window.open('http://localhost:5000/viewer?StudyInstanceUIDs='+study_instance, '_blank').focus();
// i = i + 1;
// const result_left = 100 + (i * 50);
// window.open(`http://localhost:8000/view/report/popup/${patientId}/${study_instance}`, `popupWindow${study_instance}`, `width=${halfWidth},height=${height},left=${result_left},top=${top}`);
// return;
// }



        $(function () {
            let dateInterval = getQueryParameter('date_filter');
            let start = moment().startOf('isoWeek');
            let end = moment().endOf('isoWeek');
            if (dateInterval) {
                dateInterval = dateInterval.split(' - ');
                start = dateInterval[0];
                end = dateInterval[1];
            }
            $('#date_filter').daterangepicker({
                "showDropdowns": true,
                "showWeekNumbers": true,
                "alwaysShowCalendars": true,
                startDate: start,
                endDate: end,
                clear: true,
                locale: {
                    format: 'YYYY-MM-DD',
                    firstDay: 1,
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                    'All time': [moment().subtract(30, 'year').startOf('month'), moment().endOf('month')],
                }
            });
        });
        function getQueryParameter(name) {
            const url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    </script>


@endsection