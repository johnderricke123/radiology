@extends('layouts.master')
@section('title')
View DICOM Result
@endsection

@section('content')

<style>
   #doctorname {
      position: fixed;
      bottom: 80px;
      right: 90px;
      font-size: 18px;
   }

</style>

<div class="row mb-10" style="margin-bottom: 8px;">
   <div class="col-sm-12">
      <div class="card p-2">
         <div class="card-body row">
               <div class="col-sm-4">
                  <h1 class="h3 mb-0 text-gray-800">View Result</h1>
               </div>
               <div class="col-sm-8 text-right">
                  <a href="/patient/all" class="btn btn-success btn-sm"><i class="fas fa-chevron-left"></i> Back</a>
                          <!-- <button  onclick='printDiv("printableArea");' class="d-sm-inline-block btn btn-sm btn-primary shadow-sm print_prescription"> -->
                                 <!-- <i class="fas fa-print fa-sm text-white-50"></i> Print</button>   -->
                        <a href="/patient/print/report/{{$result->id}}" target="_blank" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm print_prescription">
                        <i class="fas fa-print fa-sm text-white-50"></i> Print
                        </a>
                                 
                  
                  <a href="/dicom/patient/all" class="btn btn-sm btn-info"><i class="fas fa-list"></i> Dicom List</a>
               </div>
         </div>
      </div>
   </div>
</div>

   <div class="row">
      <div class="col-sm-12" >
         <div class="card p-3">
            <div class="card-body" id="printableArea">
                  <div id="logo-header" class="row for-print">
                           <div class="col-sm-2"></div>
                           <div class="col-sm-3 text-right">
                                 <img src="{{ asset('uploads/hch-logo.svg') }}" id="image" alt="test" width="120px" height="120px" />
                           </div>
                           <div class="col-sm-5">
                              <h3>HOLY CHILD HOSPITAL</h3>
                              <span><b>Bishop Epifanio Surban Street</b></span><br>
                              <span><b>6200 Dumaguete City, Philippines</b></span><br>
                              <span><b>Phone: (035) 225-0510; email add: holychild65@yahoo.com</b></span><br><br>
                           </div>
                           <div class="col-sm-2"></div>
                           <div class="text-center"><br>
                              <span><b>DEPARTMENT OF RADIOLOGY</b></span><br><br>
                           </div>
                  </div>
               
                  <div class="row">
                        <div id="patient-info" class="col-sm-12">
                          
                           <div class="row">
                              <div class="col-sm-5 text-uppercase"><span>Name: <b><?php echo $patient[0]->name . ", " . $patient[0]->first_name . " " . $patient[0]->middle_name; ?></b></span></div>
                              <div class="col-sm-3">Patient No.:<b>{{ $patient[0]->dicom_patient_id }}</b></div>
                              <div class="col-sm-3">Capture Date:<b> {{ \Carbon\Carbon::parse($result->study_date)->format('M d Y g:i A') }}</b></div>
                              <div class="col-sm-1">Room No.:<b></b></div>
                           </div>
                           <div class="row">
                              <div class="col-sm-3"><span>Date Result: <b>{{ $result->created_at->format('d M Y') }}</b></span></div>
                              <div class="col-sm-3">Exam No.: <b></b></div>
                              <div class="col-sm-3">Case No.: <b>{{$result->case_no}}</b></div>
                              <div class="col-sm-3">Modality.: <b>{{$result->modality}}</b></div>
                           </div>
                           <div class="row">
                              <div class="col-sm-2"><span>Age: <b>{{ \Carbon\Carbon::parse($patient[0]->birthday)->age }}</b></span></div>
                              <div class="col-sm-2">Sex: <b>{{$patient[0]->gender}}</b></div>
                              <div class="col-sm-3">Birthdate: <b>{{$patient[0]->birthday}}</b></div>
                              <div class="col-sm-2"><span>C.S.: <b>{{$result->cs}}</b></span></div>
                              <div class="col-sm-3">Plate No.: <b>{{$result->plate_no}}</b></div>
                           </div>
                           <div class="row">
                           <div class="text-left col-sm-3">Examination: <b></b></div>
                           <div class="text-left col-sm-3">Series Description: <b>{{ $result->series_desc }}</b></div>
                              <div class="col-sm-2">Body Part: <b>{{ $result->body_part }}</b></div>
                              <div class="col-sm-4">Refering Physician: <b>@if(!empty($physician)) {{ $physician->name }}, {{ $physician->first_name }} {{ $physician->middle_name }} - {{ $physician->position }} @endif</b></div><br>
                           </div>
                           <div class="row">
                              <div class="col-sm-12">
                                 Requesting Physician: <b></b>
                                 <hr>
                              </div>
                            
                              <div id="result-Content" class="col-sm-12 text-center" style="margin-top: 5%;">
                              <h4>Findings:</h4>

                                <?php foreach($findings as $finding): ?>
                                 <h4><b>{{ $finding->test_name }}</b></h4>
                                
                                 <div class="text-center col-sm-12">
                                    <p>
                                       {!! $finding->findings !!}
                                    </p>
                                 </div>
                                 
                                 <!-- <div class="text-center col-sm-12" style="margin-top: 3%;">
                                   <h4> Impressions: </h4>
                                   <p>
                                    {!! $finding->impressions !!}
                                 </p>
                                 </div> -->
                                 <?php endforeach; ?>

                              </div>
                           </div>
                        </div>
                  </div>
                  
                  <div id="report" class="row footer col-12">
                     <div class="col-sm-6">
                            <small><i>*This is a computer generated result. Signature is not required.</i></small>
                     </div>
                     <div class="col-sm-2">
                       
                     </div>
                     <div class="col-sm-3 text-center">
                        <hr>
                         Radiologist
                     </div>
                  </div>
            </div>
         </div>
      </div>
   </div>

   <script>
   
       function printDiv(printpage) { 
            var divContents = document.getElementById("printableArea").innerHTML; 
            var a = window.open(); 
            a.document.write('<html>'); 
            a.document.write('<head><title> HCH App - Print DICOM Result</title>');
            a.document.write('<link href="{{ asset("dashboard/css/sb-admin-2.min.css") }}" rel="stylesheet"  media="all"><link href="{{ asset("css/print.css") }}" rel="stylesheet"  media="all"></head>');             
            a.document.write('<body>'); 
            a.document.write(divContents); 
            a.document.write('</body></html>'); 
            setTimeout(function () {
            a.print();
            a.close();
            }, 500)
            return true;
            // a.document.close(); 
            // a.print(); 
        } 
   </script>
@endsection