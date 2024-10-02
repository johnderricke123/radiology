@extends('layouts.master')

@section('title')
{{ __('sentence.DICOM List') }}
@endsection

@section('content')


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-6">
                <h6 class="m-0 font-weight-bold text-primary w-75 p-2">Patient Studies</h6>
                <h3><?php echo $results[0]->name." ".$results[0]->first_name." ".$results[0]->middle_name; ?></h3>
            </div>
            <div class="col-4">
                <form method="post" action="http://192.168.254.112:8000/search/dicom/patient">
                    <input type="hidden" name="_token" value="CfVgTSe3Yx8Iwlke977d3h9mlwsgIKffwAGka5bP">
                    <div class="input-group p-2">
                        <input type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" name="nameOrPatientId" class="form-control text-right shadow p-3 bg-white border-0 small navbar-search">
                        <div class="input-group-append"><button type="submit" class="btn btn-primary text-right"><i class="fas fa-search fa-sm"></i></button></div>
                    </div>
                </form>
            </div>
            <div class="col-2">

            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered display compact" id="dataTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Exam Number</th>
                        <th>Test Name</th>
                        <th class="text-center">Modality</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($results as $result): ?>
                    <tr>
                        <td> {{$result->dp_id}}</td>
                        <td> {{$result->exam_number}} </td>
                        <td> {{$result->test_name}} </td>
                        <td> {{$result->result}} </td>
                        <td class="text-center">
                            <a href="/patient/print/report/{{$result->result_table_id}}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fa fa-print"></i></a>
                            <a href="#" class="btn btn-outline-success btn-sm" ><i class="fa fa-eye"></i></a>
                            <!-- <a href="http://localhost:5000/viewer?StudyInstanceUIDs=1.2.840.113564.0.190.67.226.79.197.20240531134515338.11080" target="_blank" class="btn btn-outline-warning btn-sm" title="View Study"><img class="fa grey" width="16" src="http://192.168.254.112:8000/webfonts/x-ray-solid.svg" /> </a> -->
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <span class="float-right mt-3"></span>
    </div>
</div>




@endsection