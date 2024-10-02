@extends('layouts.master')

@section('title')
Patient Study List
@endsection

@section('content')
<!-- <h1>Patient Study List</h1> -->


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-3">
                <h6 class="m-0 font-weight-bold text-primary w-75 p-2"><img class="fa fa-grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /> Patient Studies</h6>
            </div>
            <div class="col-3">

            </div>
            <div class="text-right col-6">
            
                <!-- <h5>{{$studies[0]->PatientNam}}  <br>Patient ID:<strong>{{$studies[0]->PatientID}}</strong></h5> -->
                <h5>{{ $str = preg_replace('/[^A-Za-z0-9. -]/', ', ', $studies[0]->PatientNam ) }} <br>Patient ID:<strong>{{$studies[0]->PatientID}}</strong></h5>
            </div>
            <!-- **************************** -->

            <!-- ***************************** -->
        </div>
    </div>
    <div class="card-body">
        <p><?php //var_dump($studies); ?></p>
        <div class="table-responsive">
            <table class="table stripe row-border" id="dataTable" cellspacing="0">
                <thead>
                    <tr>
                        
                        <th>Study Instance</th>
                        <th>Referring Physician</th>
                        <th class="text-center">Modality</th>
                        <th class="text-center">Study Date</th>
                        
                        <th width="15%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($studies as $study)
                        <tr>
                            <td> {{$study->StudyInsta}}</td>
                            <td class="text-center"><?php echo $study->ReferPhysi ?: "Null" ?></td>
                            <td class="text-center"> {{$study->StudyModal}} </td>
@php
$time = explode(".", $study->StudyTime)[0];
@endphp
                            <td class="text-center">{{Carbon\Carbon::createFromFormat('Ymd His', $study->StudyDate." ".$time)->format('Y/m/d g:i A')}}</td>
                            
                            <td class="text-center">
                                <div claas="row" style="display:inline-flex;">
                                    @if(Auth::user()->can('create appointment'))
                                        <form method="get" action="/view/dicom/patient/{{$study->PatientID}}">
                                            <input type="hidden" name="study_insta" value="{{$study->StudyInsta}}"/>
                                            <button  type="submit" <?php if($study->hasReport == "1"){ echo "disabled";} ?> class="btn btn-outline-<?php if($study->hasReport == "1"){ echo "secondary";}else{ echo "success";} ?> btn-sm"><i class="fa fa-edit"></i></button>
                                        </form>
                                    @endif
                                    <!-- <a href="{{ route('dicom.patient.studies', ['id' => $study->PatientID]) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a> -->
                                    <a class="btn btn-outline-secondary btn-sm" title="View Dicom" onclick='openPopup("<?php echo $study->StudyInsta; ?>",<?php echo $study->PatientID; ?>)' ><img class="fa grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /></a>
                                    <!-- <a href="#" onclick='openPopup("{{$study->StudyInsta}}", {{$study->PatientID}})' class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a> -->
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <span class="float-right mt-3"></span>
    </div>
</div>
@endsection