@extends('layouts.master')
<link rel="yandex-tableau-widget" href="/assets/yandex-browser-manifest.json"/>
	<script rel="preload" as="script" src="../js/app-config.js"></script>
	<script rel="preload" as="script" type="module" src="../js/init-service-worker.js"></script>
	<title>HCH Viewer</title>
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
	<link href="https://fonts.googleapis.com/css?family=Inter:100,300,400,500,700&display=swap" rel="stylesheet" rel="preload" as="style"/>

@section('title')
{{ __('sentence.All Patients') }}
@endsection

@section('content')

          <div class="card shadow mb-4">
            <div class="card-header py-3">
               <div class="row">
                <div class="col-6">
                    <h6 class="m-0 font-weight-bold text-primary w-75 p-2"><i class="fas fa-fw fa-user-injured"></i> {{ __('sentence.All Patients') }}</h6>
                </div>
                <div class="col-4">
                 <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="{{ route('patient.search') }}" method="post">
                        <div class="input-group">
                            <input type="text" name="term" class="form-control border-1 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            @csrf
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-2">
                  @can('add patient')
                  <a href="{{ route('patient.create') }}" class="btn btn-primary btn-sm float-right "><i class="fa fa-plus"></i> {{ __('sentence.New Patient') }}</a>
                  @endcan
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table stripe" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Date Added</th>
                      <th>{{ __('sentence.Patient Name') }}</th>
                      <th>First Name</th>
                      <th>Middle Name</th>
                      <th class="text-center">{{ __('sentence.Age') }}</th>
                      <th class="text-center">{{ __('sentence.Gender') }}</th>
                      <!-- <th class="text-center">{{ __('sentence.Blood Group') }}</th> -->
                      <!-- <th class="text-center">{{ __('sentence.Date') }}</th>
                      <th class="text-center">{{ __('sentence.Due Balance') }}</th> -->
                      <th class="text-center">DICOM</th>
                      <!-- <th class="text-center">{{ __('sentence.Prescriptions') }}</th> -->
                      <th class="text-center">{{ __('sentence.Actions') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($patients as $patient)
                    <tr>
                      <td><label class="badge badge-primary-soft">{{ \Carbon\Carbon::parse($patient->created_at)->format('d M Y g:i A') }}</label></td>
                      <td><a href="{{ url('patient/view/'.$patient->id) }}"> {{ $patient->name }} </a></td>
                      <td><a href="{{ url('patient/view/'.$patient->id) }}"> {{ $patient->first_name }} </a></td>
                      <td><a href="{{ url('patient/view/'.$patient->id) }}"> {{ $patient->middle_name }} </a></td>
                      <td class="text-center"> {{ @\Carbon\Carbon::parse($patient->birthday)->age }} </td>
                      <td class="text-center"> {{ @$patient->gender }} </td>
                      <!-- <td class="text-center"> {{ @$patient->blood }} </td> -->
                      <!-- <td class="text-center"><label class="badge badge-primary-soft">{{ $patient->created_at->format('d M Y H:i') }}</label></td> -->
                      <!-- <td class="text-center"><label class="badge badge-primary-soft">{{ Collect($patient->Billings)->where('payment_status','Partially Paid')->sum('due_amount') }} {{ App\Setting::get_option('currency') }}</label></td> -->
                      <!-- <td class="text-center"></td> -->
                      <td class="text-center">
                      <label class="badge badge-primary-soft">
                        {{ count($patient->Result) }} Results
                     </label>                       
                      </td>
                      <td class="text-center">
                        @can('view patient')
                        <a href="{{ route('patient.view', ['id' => $patient->id]) }}" class="btn btn-outline-success btn-circle btn-sm"><i class="fa fa-eye"></i></a>
                        @endcan
                        @can('edit patient')
                        <a href="{{ route('patient.edit', ['id' => $patient->id]) }}" class="btn btn-outline-warning btn-circle btn-sm"><i class="fa fa-pen"></i></a>
                        @endcan
                        @can('delete patient')
                        <!-- <a href="#" class="btn btn-outline-danger btn-circle btn-sm" data-toggle="modal" data-target="#DeleteModal" data-link="{{ route('patient.destroy' , ['id' => $patient->id ]) }}"><i class="fas fa-trash"></i></a> -->
                        @endcan
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="9"  align="center"><img src="{{ asset('img/rest.png') }} "/> <br><br> <b class="text-muted">No patients found!</b>
                        
                      </td>
                    </tr>
                    @endforelse
                   
                  </tbody>
                </table>
              

              </div>

            </div>
          </div>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
   <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
   <!-- Include Required Prerequisites -->
   <!-- <script src="code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script> -->


       
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
          <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script type="text/javascript">
  new DataTable('#dataTable');

</script>

@endsection

  