@extends('layouts.master')

@section('title')
Add Findings
@endsection

@section('content')

<div class="card shadow mb-4">
<div class="card-header py-3"> 
    <div class="row">
        <div class="col-2">
            <h6 class="m-0 font-weight-bold text-primary w-50 p-2"><i class="fa fa-table"></i> Reports</h6>
        </div>
        <div class="col-6">
                    <form action="{{ route('reports.all')}}" method="get">
                        <!-- <div class="form-group row"> -->
                            <div class="input-group p-2">
                                <input type="text" class="form-control" name="date_filter" id="date_filter"/>
                                <div class="input-group-append"> <input type="submit" name="filter_submit" class="btn btn-success" value="Filter" /></div>
                                <div class="input-group-append"> <a href="{{ route('reports.all','filter=All') }} " class="btn btn-info">All</a></div>
                                <div class="input-group-append"> <a href="{{ route('reports.all') }} " class="btn btn-warning">Clear</a></div>
                            
                            </div>
                            <!-- </div> -->
                        </form>
                    </div>
        <div class="col-4 p-2 text-right">
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="{{ url('/') }}/patient/search" method="post">
                <div class="input-group">
                    <input type="text" name="term" class="form-control border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <input type="hidden" name="_token" value="MncJ0ANLwqiPg5Ri8Ier5LpHPTGoXRBJIQQLdaym">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-2 p-2">
            <!-- <a href="{{ url('/') }}/patient/create" class="btn btn-primary btn-sm float-right "><i class="fa fa-plus"></i> New Patient</a> -->
        </div>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="example" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Study Date</th>
                    <th>Result Date</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Gender</th>
                    <th>Reader</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result as $res)
                <tr>
                    <td><label class="badge badge-primary-soft">
                        {{ \Carbon\Carbon::parse($res->study_date)->format('M d Y g:i A') }}
                    </label></td>
                    <td><label class="badge badge-primary-soft">
                    {{ \Carbon\Carbon::parse($res->created_at)->format('M d Y g:i A') }}
                    </label></td>
                    <td><a href="{{ url('/') }}/patient/view/{{$res->patient_id}}"> {{ $res->patient_lname}} </a></td>
                    <td><a href="{{ url('/') }}/patient/view/{{$res->patient_id}}"> {{ $res->patient_fname}} </a></td>
                    <td class="text-center"> {{ $res->patient_gender}} </td>
                    <td class="text-center">{{ $res->creator}}, {{$res->creator_fname}} {{$res->creator_mname}}</td>
                    <td class="text-center">
                        <a href="{{ url('/') }}/result/view/{{$res->result_id}}" class="btn btn-outline-success btn-circle btn-sm"><i class="fa fa-eye"></i></a>
                        <!-- <a href="http://localhost:8000/patient/edit/48" class="btn btn-outline-warning btn-circle btn-sm"><i class="fa fa-pen"></i></a> -->
                        <!-- <a href="#" class="btn btn-outline-danger btn-circle btn-sm" data-toggle="modal" data-target="#DeleteModal" data-link="http://localhost:8000/patient/delete/48"><i class="fas fa-trash"></i></a> -->
                    </td>
                </tr>
                @endforeach


            </tbody>
        </table>



    </div>

</div>
</div>
</div>
</div>

<script src="{{ asset('js/datatables/jquery-3.7.1.js') }}"></script>
        
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="{{ asset('js/datatables/dataTables.buttons.js') }}"></script>
<script src="{{ asset('js/datatables/buttons.dataTables.js') }}"></script>
<script src="{{ asset('js/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('js/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/datatables/buttons.print.min.js') }}"></script>




    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js" defer></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables/buttons.dataTables.css') }}"/>

<script type="text/javascript">
    new DataTable('#example', {
        order: [[1, 'asc']],
        layout: {
        top1Start: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
    }
    });
</script>
<script>
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