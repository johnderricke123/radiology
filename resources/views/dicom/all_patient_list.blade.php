@extends('layouts.master')

@section('title')
Patient List
@endsection

@section('content')


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-3">
                <h6 class="m-0 font-weight-bold text-primary w-75 p-2"><img class="fa fa-grey" width="16" src="http://localhost:8000/webfonts/x-ray-solid.svg" /> All Patients</h6>
            </div>
            <div class="col-6">
                <!-- ******************************************************* -->
            </div>
            <div class="col-3">
                <div class="input-group">
                    <!-- <span class="input-group-text" id="basic-addon1">Search</span> -->
                    <input type="search" class="form-control rounded-0" id="search" placeholder="Search here..." value="">
                </div>
                <!-- **************************************************** -->
            </div>
            <!-- **************************** -->

            <!-- ***************************** -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <!-- <table id="membersTbl" class="table table-sm table-bordered table-striped"> -->
        <table id="membersTbl" class="table stripe row-border" cellspacing="0">
        
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $member)
                        <tr>
                            <td class="text-center">{{$member->PatientID}}</td>
                            <!-- <td>{{$member->PatientNam}} </td> -->
                            <td>{{ $str = preg_replace('/[^A-Za-z0-9. -]/', ', ', $member->PatientNam ) }}</td>
                            <td>{{$member->PatientBir}}</td>
                            <td>{{$member->PatientSex}}</td>
                            <td><a href="{{ route('dicom.patient.studies', ['id' => $member->PatientID]) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <!-- Data Table -->

        </div>
        <span class="float-right mt-3"></span>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    // Ajax Variable
    var search_ajax;
    $(document).ready(function(){
        
        // Execute Live Searcing when search box input has character entered or change
        $('#search').on('input change', function(e){
            e.preventDefault()
            var searchTxt = $(this).val()
            var urlParams = new URLSearchParams(location.search);            
            var newParams = []
            // urlParams.forEach((v, k) => {
            //     if(k == 'q'){
            //         v = searchTxt
            //     }
            //     if(searchTxt != "" && k == 'q')
            //        newParams.push(`${k}=${encodeURIComponent(v)}`);
            // })

            // if(newParams.length > 0){
            //     var newLink = `{{URL::to('/')}}?`+(newParams.join('&'));
            //     history.pushState({}, "", newLink)
            // }else{
            //     if(searchTxt != ""){
            //         history.pushState({}, "", `{{URL::to('/')}}?q=${encodeURIComponent(searchTxt)}`)
            //     }else{
            //         history.pushState({}, "", `{{URL::to('/')}}`)
            //     }
 
            // }
 
            // if(search_ajax != undefined && search_ajax != null){
            //    search_ajax.abort();
            // }
            //console.log(searchTxt);return;
            // Start Search Ajax Process
            search_ajax = $.ajax({
                url:`{{URL::to('/search/patient')}}?q=${searchTxt}`,
                
                dataType:'json',
                error: err => {
                    console.log(err)
                    if(err.statusText != 'abort')
                        alert('An error occurred');
                },
                success: function(resp){
                    // console.log(resp);return;
//***************************MUGANA NGA CODE***************************
                    var data = resp['patients']['data'];
                    var tableBody = $("#membersTbl tbody");
                    tableBody.empty(); 
                    var tblBody = $('#membersTbl tbody')
                    Object.values(data).map(data => {
                                var tr = $('<tr>')
                                tr.append(`<td class="text-center">${data.PatientID}</td>`)
                                var patientNam = `${data.PatientNam}`;
                                const str = patientNam.replace(/[^A-Za-z0-9. -]/g, ', ');
                                //tr.append(`<td>${data.PatientNam}  </td>`)
                                tr.append(`<td>${str}  </td>`)
                                tr.append(`<td>${data.PatientBir}</td>`)
                                tr.append(`<td>${data.PatientSex}</td>`)
                                tr.append(`<td><a href="/dicom/patient/studies/${data.PatientID}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a></td>`)

                                tblBody.append(tr)

                    });
                    return;
//***************************MUGANA NGA CODE***************************
                }
            })
        })
    })
</script>
@endsection