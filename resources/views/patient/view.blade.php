@extends('layouts.master')

@section('title')
{{ $patient->name }}
@endsection

@section('content')

    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow mb-4">
                
                <div class="card-body">
                  <div class="row"> 
                    <div class="col-md-12 text-right col-sm-6">
                        <a href="/patient/all" class="btn btn-sm btn-info"><i class="fas fa-list"></i> Result List</a>
                    <div class="col-md-4 col-sm-6">
                  </div>
                  <div class="row">
                    <div class="col-md-4 col-sm-6">
                      @empty(!$patient->image)
                      <center><img src="{{ asset('uploads/'.$patient->image) }}" class="img-profile rounded-circle img-fluid" width="256" height="256"></center>
                      @else
                      <center><img src="{{ asset('img/patient-icon.png') }}" class="img-profile rounded-circle img-fluid" width="256" height="256"></center>
                      @endempty
                       <h4 class="text-center mt-3"><b>{{ $patient->name }}, {{ $patient->first_name }} {{ $patient->middle_name }}</b> <label class="badge badge-primary-soft"> <a href="{{ url('patient/edit/'.$patient->id) }}" ><i class="fa fa-pen"></i></a></label></h4>
                       
                       <hr>

                            @isset($patient->birthday)
                            <p><b>{{ __('sentence.Birthday') }} :</b> {{ $patient->birthday }} ({{ \Carbon\Carbon::parse($patient->birthday)->age }} Years)</p>
                            @endisset

                            @isset($patient->gender)
                            <p><b>{{ __('sentence.Gender') }} :</b> {{ $patient->gender }}</p> 
                            @endisset

                            @isset($patient->phone)
                            <p><b>{{ __('sentence.Phone') }} :</b> {{ $patient->phone }}</p>
                            @endisset

                            @isset($patient->adress)
                            <p><b>{{ __('sentence.Address') }} :</b> {{ $patient->adress }}</p>
                            @endisset
                            @isset($patient->weight)
                            <p><b>{{ __('sentence.Weight') }} :</b> {{ $patient->weight }} Kg</p>
                            @endisset

                            @isset($patient->height)
                            <p><b>{{ __('sentence.Height') }} :</b> {{ $patient->height }} cm</p>
                            @endisset

                            @isset($patient->blood)
                            <p><b>{{ __('sentence.Blood Group') }} :</b> {{ $patient->blood }}</p>
                            @endisset
                    </div>
                    <div class="col-md-8 col-sm-6">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                          <a class="nav-link  active" id="dicom-tab" data-toggle="tab" href="#dicom" role="tab" aria-controls="dicom" aria-selected="false">Dicom Results</a>
                        </li>
                        <li class="nav-item" role="presentation">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="Profile" aria-selected="true">{{ __('sentence.Health History') }}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                          <a class="nav-link" id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="false">Medical Files</a>
                        </li>
                        <li class="nav-item" role="presentation">
                          <a class="nav-link" id="appointements-tab" data-toggle="tab" href="#appointements" role="tab" aria-controls="appointements" aria-selected="false">{{ __('sentence.Appointments') }}</a>
                        </li>
                      
                      </ul>
                      <div class="tab-content" id="myTabContent">
                      <div class="tab-pane  fade show active" id="dicom" role="tabpanel" aria-labelledby="dicom-tab">
                          
                      <table class="table table-bordered row-border compact" id="example" cellspacing="0">
                        <thead>
                            <tr>
                            <th class="text-center col-sm-1">#</th>
                              <th class="col-sm-2">Result Date</th>
                              <th class="col-sm-2">Modality</th>
                              <th class="col-sm-2" align="center">Body Part</th>
                              <th class="col-sm-2" align="center">Captured Date</th>
                              <th class="col-sm-3" align="center">Action </th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i = 1; ?>
                            @forelse($dicom as $result)
                            <tr> 
                              <td class="text-center"><?php echo $i; ?></td>                      
                              <td  align="center"><label class="badge badge-primary-soft">{{ \Carbon\Carbon::parse($result->created_at)->format('M d Y g:i a') }}</label></td>
                              <td align="center" >{{ $result->modality }} </td>
                              <td align="center">{{ $result->body_part }} </td>
                              <td align="center">
                                {{ \Carbon\Carbon::parse($result->study_date)->format('M d Y') }}
                                {{ \Carbon\Carbon::parse($result->created_at)->format('g:i A') }}
                              </td>
                                                        
                              <td width="30%" align="center">                               
                                <a href="{{ url('/') }}{{ '/result/view/'.$result->id }}" title="View" class="btn btn-outline-success btn-circle btn-sm"><i class="fa fa-eye"></i></a>
                                @if(Auth::user()->can('create appointment'))
                                    @if($result->created_by == Auth::user()->id)
                                      <a href="{{ url('result/update_result/'.$result->id) }}" title="Update" class="btn btn-outline-info btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                                    @endif
                                @endif
                                <!-- <a href="/patient/print/report/{{$result->id}}" target="_blank" title="Print Report" class="btn btn-outline-primary btn-circle btn-sm"><i class="fa fa-print"></i></a> -->
<!-- *********************TEMPORARY FIXED********************* -->
                                @if(request()->getHost() == "xray.hchdgte.com")
                                  <a class="btn btn-outline-secondary btn-circle btn-sm" title="View Dicom" onclick='window.open("https://www.hchdgte.com/viewer?StudyInstanceUIDs={{ $result->study_instance }}",  "_blank", "width=720, height=1200", "class=btn btn-outline-warning btn-sm", "title=View Study");' ><img class="fa grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /> </a>
                                @endif
                                @if(request()->getHost() != "xray.hchdgte.com")
                                <?php //echo "IP Address of client " . getenv("REMOTE_ADDR");  ?>
                                @if(getenv("REMOTE_ADDR") == "192.168.254.157")
                                  <a class="btn btn-outline-secondary btn-circle btn-sm" title="View Dicom" onclick='window.open("https://www.hchdgte.com/viewer?StudyInstanceUIDs={{ $result->study_instance }}",  "_blank", "width=720, height=1200", "class=btn btn-outline-warning btn-sm", "title=View Study");' ><img class="fa grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /> </a>
                                @endif
                                @if(getenv("REMOTE_ADDR") != "192.168.254.157")
                                  <a href="http://192.168.254.100:5000/viewer?StudyInstanceUIDs={{ $result->study_instance }}" target="_blank" class="btn btn-outline-secondary btn-circle btn-sm" title="View Dicom" ><img class="fa grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /> </a>
                                @endif
<!-- *********************TEMPORARY FIXED********************* -->
                                <!-- <a class="btn btn-outline-secondary btn-circle btn-sm" title="View Dicom" onclick='window.open("http://192.168.254.100:5000/viewer?StudyInstanceUIDs={{ $result->study_instance }}",   "width=720, height=1200", "class=btn btn-outline-warning btn-sm", "title=View Study");' ><img class="fa grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /> </a> -->
                                <!-- <a href="http://192.168.254.100:5000/viewer?StudyInstanceUIDs={{ $result->study_instance }}" target="_blank" class="btn btn-outline-secondary btn-circle btn-sm" title="View Dicom" ><img class="fa grey" width="16" src="{{ asset('webfonts/x-ray-solid.svg') }}" /> </a> -->


                                
                                @endif
                               @if(Auth::user()->can('create appointment'))
                                  <a href="/download/dicom/folder/{{$result->dicom_patient_id}}" title="Download Dicom" class="btn btn-outline-warning btn-circle btn-sm"><i class="fa fa-download" aria-hidden="true"></i></a>                                
                                @endif
                              </td>
                            </tr>
                            <?php $i++; ?>
                             @empty
                            <tr>
                              <td></td>
                              <td></td>
                              <td align="center"> <img src="{{ asset('img/not-found.svg') }}" width="200" /> <br><br> <b class="text-muted"> {{ __('sentence.No prescription available') }}</b></td>
                              <td></td>
                              <td></td>
                            </tr>
                            
                            @endforelse
                        </tbody>
                          </table>

                    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
                    <script type="text/javascript" src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
                    <script type="text/javascript">
                      new DataTable('#example', {
                          order: [[0, 'asc']]
                      });
                    </script>

                        </div>

                        <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                          <div class="row">
                            <div class="col">
                              @can('create health history')
                                <button type="button" class="btn btn-primary btn-sm my-4 float-right" data-toggle="modal" data-target="#MedicalHistoryModel"><i class="fa fa-plus"></i> Add New</button>
                              @endcan
                            </div>
                          </div>

                          @forelse($historys as $history)
                          <div class="alert alert-danger">
                              <p class="text-danger font-size-12">
                                {!! clean($history->title) !!} - {{ $history->created_at }}
                                @can('delete health history')
                                <span class="float-right"><i class="fa fa-trash"  data-toggle="modal" data-target="#DeleteModal" data-link="{{ url('history/delete/'.$history->id) }}"></i></span>
                                @endcan
                              </p>
                            {!!  clean($history->note) !!}
                          </div>
                          @empty
                          <center><img src="{{ asset('img/not-found.svg') }}" width="200" /> <br><br> <b class="text-muted">No health history was found</b></center>
                          @endforelse
                           

                            

                          
                        </div>
                        <div class="tab-pane fade" id="appointements" role="tabpanel" aria-labelledby="appointements-tab">
                          <div class="row">
                            <div class="col">
                              @can('create appointment')
                                <a type="button" class="btn btn-primary btn-sm my-4 float-right" href="{{ route('appointment.create') }}"><i class="fa fa-plus"></i> {{ __('sentence.New Appointment') }}</a>
                              @endif
                            </div>
                          </div>
                          <table class="table stripe">
                          <thead>
                          <tr>
                              <th align="center">Id</th>
                              <th align="center">{{ __('sentence.Date') }}</th>
                              <th align="center">{{ __('sentence.Time Slot') }}</th>
                              <td align="center">{{ __('sentence.Status') }}</th> 
                              <th align="center">{{ __('sentence.Actions') }}</th>
                            </tr>
                          </thead>
                            @forelse($appointments as $appointment)
                            <tbody>
                            <tr>
                              <td align="center">{{ $appointment->id }} </td>
                              <td align="center"><label class="badge badge-primary-soft"><i class="fas fa-calendar"></i> {{ $appointment->date->format('d M Y') }} </label></td>
                              <td align="center"><label class="badge badge-primary-soft"><i class="fa fa-clock"></i> {{ $appointment->time_start }} - {{ $appointment->time_end }} </label></td>
                               <td class="text-center">
                                @if($appointment->visited == 0)
                                  <label class="badge badge-warning-soft">
                                    <i class="fas fa-hourglass-start"></i> {{ __('sentence.Not Yet Visited') }}
                                  </label>
                                @elseif($appointment->visited == 1)
                                <label class="badge badge-success-soft">
                                    <i class="fas fa-check"></i> {{ __('sentence.Visited') }}
                                </label>
                                @else
                                <label class="badge badge-danger-soft">
                                    <i class="fas fa-user-times"></i> {{ __('sentence.Cancelled') }}
                                  </label>
                                @endif
                              </td>
                              <td align="center">
                                @can('edit appointment')
                                <a data-rdv_id="{{ $appointment->id }}" data-rdv_date="{{ $appointment->date->format('d M Y') }}" data-rdv_time_start="{{ $appointment->time_start }}" data-rdv_time_end="{{ $appointment->time_end }}" data-patient_name="{{ $appointment->User->name }}" class="btn btn-outline-success btn-circle btn-sm" data-toggle="modal" data-target="#EDITRDVModal"><i class="fas fa-check"></i></a>
                                @endcan
                                @can('delete appointment')
                                <a href="{{ url('appointment/delete/'.$appointment->id) }}" class="btn btn-outline-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a>
                                @endcan
                              </td>
                            </tr>
                            @empty
                            <tr>
                              <td colspan="5" align="center"><img src="{{ asset('img/not-found.svg') }}" width="200" /> <br><br> <b class="text-muted">{{ __('sentence.No appointment available') }}</b></td>
                            </tr>
                            @endforelse
                            </tbody>
                          </table>
                        </div>

                        <div class="tab-pane fade" id="prescriptions" role="tabpanel" aria-labelledby="prescriptions-tab">
                          <div class="row">
                            <div class="col">
                              @can('create prescription')
                                <a class="btn btn-primary btn-sm my-4 float-right" href="{{ route('prescription.create')}}"><i class="fa fa-pen"></i> {{ __('sentence.Write New Prescription') }}</a>
                              @endcan
                            </div>
                          </div>
                          <table class="table">
                            <tr>
                              <td align="center">{{ __('sentence.Reference') }}</td>
                              <td class="text-center">{{ __('sentence.Content') }}</td>
                              <td align="center">{{ __('sentence.Created at') }}</td>
                              <td align="center">{{ __('sentence.Actions') }}</td>
                            </tr>
                            @forelse($prescriptions as $prescription)
                            <tr>
                              <td align="center">{{ $prescription->reference }} </td>
                              <td class="text-center"> 
                                 <label class="badge badge-primary-soft">
                                    {{ count($prescription->Drug) }} Drugs
                                 </label>
                                 <label class="badge badge-primary-soft">
                                    {{ count($prescription->Test) }} Tests
                                 </label> 
                              </td>
                              <td align="center"><label class="badge badge-primary-soft">{{ $prescription->created_at }}</label></td>
                              <td align="center">
                                @can('view prescription')
                                <a href="{{ url('prescription/view/'.$prescription->id) }}" class="btn btn-outline-success btn-circle btn-sm"><i class="fa fa-eye"></i></a>
                                @endcan
                                @can('edit prescription')
                                <a href="{{ url('prescription/edit/'.$prescription->id) }}" class="btn btn-outline-warning btn-circle btn-sm"><i class="fas fa-pen"></i></a>
                                @endcan
                                @can('delete prescription')
                                <a href="{{ url('prescription/delete/'.$prescription->id) }}" class="btn btn-outline-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a>
                                @endcan
                              </td>
                            </tr>
                             @empty
                            <tr>
                              <td colspan="4" align="center"> <img src="{{ asset('img/not-found.svg') }}" width="200" /> <br><br> <b class="text-muted"> {{ __('sentence.No prescription available') }}</b></td>
                            </tr>
                            @endforelse
                          </table>
                        </div>

                        <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                          <div class="row">
                            <div class="col">
                              @can('edit patient')
                                <button type="button" class="btn btn-primary btn-sm my-4 float-right" data-toggle="modal" data-target="#NewDocumentModel"><i class="fa fa-plus"></i> Add New</button>
                              @endcan
                            </div>
                          </div>

                            <div class="row">
                              @forelse($documents as $document)
                              <div class="col-md-4">
                              <div class="card">
                                @if($document->document_type == "pdf")
                                  <img src="{{ asset('img/pdf.jpg') }}" class="card-img-top" >
                                @elseif($document->document_type == "docx")
                                  <img src="{{ asset('img/docx.png') }}" class="card-img-top" >
                                @else
                                  <a class="example-image-link" href="{{ url('/uploads/'.$document->file) }}" data-lightbox="example-1"><img src="{{ url('/uploads/'.$document->file) }}" class="card-img-top" width="209" height="209"></a>
                                <img src="{{ asset('img/pdf.jpg') }}" class="card-img-top" >
                                @endif
                                <div class="card-body">
                                  <h5 class="card-title">{{ $document->title }}</h5>
                                  <p class="font-size-12">{{ $document->note }}</p>
                                  <p class="font-size-11"><label class="badge badge-primary-soft">{{ $document->created_at }}</label></p>
                                  <a href="{{ url('/uploads/'.$document->file) }}" class="btn btn-primary btn-sm" download><i class="fa fa-cloud-download-alt"></i> Download</a>
                                  @can('edit patient')
                                  <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#DeleteModal" data-link="{{ url('document/delete/'.$document->id) }}"><i class="fa fa-trash"></i></a>
                                  @endcan
                                </div>
                              </div>
                              </div>
                              @empty
                              <div class="col text-center">
                                <img src="{{ asset('img/not-found.svg') }}" width="200" /> <br><br> <b class="text-muted"> {{ __('sentence.No document available') }} </b>
                              </div>

                              @endforelse

                            </div>
                        </div>


                        <div class="tab-pane fade" id="Billing" role="tabpanel" aria-labelledby="Billing-tab">
                          <div class="row mt-4">
                            <div class="col-lg-4 mb-4">
                              <div class="card bg-primary text-white shadow">
                                <div class="card-body">
                                  {{ __('sentence.Total With Tax') }}
                                  <div class="text-white small">{{ Collect($invoices)->sum('total_with_tax') }} {{ App\Setting::get_option('currency') }}</div>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                              <div class="card bg-success text-white shadow">
                                <div class="card-body">
                                  {{ __('sentence.Already Paid') }}
                                  <div class="text-white small">{{ Collect($invoices)->sum('deposited_amount') }} {{ App\Setting::get_option('currency') }}</div>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                              <div class="card bg-danger text-white shadow">
                                <div class="card-body">
                                  {{ __('sentence.Due Balance') }}
                                  <div class="text-white small">{{ Collect($invoices)->where('payment_status','Partially Paid')->sum('due_amount') }} {{ App\Setting::get_option('currency') }}</div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              @can('create invoice')
                                <a type="button" class="btn btn-primary btn-sm my-4 float-right" href="{{ route('billing.create') }}"><i class="fa fa-plus"></i> {{ __('sentence.Create Invoice') }}</a>
                              @endcan
                            </div>
                          </div>
                          <table class="table">
                            <tr>
                              <th>{{ __('sentence.Invoice') }}</th>
                              <th>{{ __('sentence.Date') }}</th>
                              <th>{{ __('sentence.Amount') }}</th>
                              <th>{{ __('sentence.Status') }}</th>
                              <th>{{ __('sentence.Actions') }}</th>
                            </tr>
                            @forelse($invoices as $invoice)
                            <tr>
                              <td><a href="{{ url('billing/view/'.$invoice->id) }}">{{ $invoice->reference }}</a></td>
                              <td><label class="badge badge-primary-soft">{{ $invoice->created_at->format('d M Y') }}</label></td>
                              <td> {{ $invoice->total_with_tax }} {{ App\Setting::get_option('currency') }}
                                  @if($invoice->payment_status == 'Unpaid' OR $invoice->payment_status == 'Partially Paid')
                                    <label class="badge badge-danger-soft">{{ $invoice->due_amount }} {{ App\Setting::get_option('currency') }} </label>
                                  @endif
                              </td>
                              <td>
                                @if($invoice->payment_status == 'Unpaid')
                                <label class="badge badge-danger-soft">
                                    <i class="fas fa-hourglass-start"></i>
                                    {{ __('sentence.Unpaid') }}
                                </label>
                                @elseif($invoice->payment_status == 'Paid')
                                <label class="badge badge-success-soft">
                                    <i class="fas fa-check"></i> {{ __('sentence.Paid') }}
                                </label>
                                @else
                                <label class="badge badge-warning-soft">
                                    <i class="fas fa-user-times"></i>
                                    {{ __('sentence.Partially Paid') }}
                                </label>
                                @endif
                              </td>
                              <td>
                                @can('view invoice')
                                <a href="{{ url('billing/view/'.$invoice->id) }}" class="btn btn-outline-success btn-circle btn-sm"><i class="fa fa-eye"></i></a>
                                @endcan
                                @can('edit invoice')
                                <a href="{{ url('billing/edit/'.$invoice->id) }}" class="btn btn-outline-warning btn-circle btn-sm"><i class="fas fa-pen"></i></a>
                                @endcan
                                @can('delete invoice')
                                <a href="{{ url('billing/delete/'.$invoice->id) }}" class="btn btn-outline-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a>
                                @endcan
                              </td>
                            </tr>
                            @empty
                            <tr>
                            </tr>
                              <td colspan="6" align="center"><img src="{{ asset('img/not-found.svg') }}" width="200" /> <br><br> <b class="text-muted">{{ __('sentence.No Invoices Available') }}</b></td>
                            @endforelse
                          </table>
                        </div>
                      </div>
                    
                    </div>
                  </div>
                </div>
              </div>
      </div>
    </div>

  <!-- Appointment Modal-->
  <div class="modal fade" id="EDITRDVModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('sentence.You are about to modify an appointment') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <p><b>{{ __('sentence.Patient') }} :</b> <span id="patient_name"></span></p>
            <p><b>{{ __('sentence.Date') }} :</b> <label class="badge badge-primary-soft" id="rdv_date"></label></p>
            <p><b>{{ __('sentence.Time Slot') }} :</b> <label class="badge badge-primary-soft" id="rdv_time"></span></label>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('sentence.Close') }}</button>
          <a class="btn btn-primary text-white" onclick="event.preventDefault(); document.getElementById('rdv-form-confirm').submit();">{{ __('sentence.Confirm Appointment') }}</a>
                                                     <form id="rdv-form-confirm" action="{{ route('appointment.store_edit') }}" method="POST" class="d-none">
                                                      <input type="hidden" name="rdv_id" id="rdv_id">
                                                      <input type="hidden" name="rdv_status" value="1">
                                                        @csrf
                                                    </form>
          <a class="btn btn-danger text-white" onclick="event.preventDefault(); document.getElementById('rdv-form-cancel').submit();">{{ __('sentence.Cancel Appointment') }}</a>
                                                     <form id="rdv-form-cancel" action="{{ route('appointment.store_edit') }}" method="POST" class="d-none">
                                                      <input type="hidden" name="rdv_id" id="rdv_id2">
                                                      <input type="hidden" name="rdv_status" value="2">
                                                        @csrf
                                                    </form>
        </div>
      </div>
    </div>
  </div>

<!--Document Modal -->
<div id="NewDocumentModel" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add File / Note</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form method="post" action="{{ route('document.store') }}" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
              <div class="col">
                <input type="text" class="form-control" name="title" placeholder="Title" required>
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                {{ csrf_field() }}
              </div>
              <div class="col">
                <input type="file" class="form-control-file" name="file" id="exampleFormControlFile1" required>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col">
                <textarea class="form-control" name="note" placeholder="Note"></textarea>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('sentence.Close') }}</button>
          <button class="btn btn-primary text-white" type="submit">{{ __('sentence.Save') }}</button>
          </form>
        </div>
      </div>
    </div>
</div>

<!--Document Modal -->
<div id="MedicalHistoryModel" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('sentence.New Medical Info') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form method="post" action="{{ route('history.store') }}" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
              <div class="col">
                <input type="text" class="form-control" name="title" placeholder="Title" required>
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                {{ csrf_field() }}
              </div>
            </div>
            <div class="row mt-2">
              <div class="col">
                <textarea class="form-control" name="note" placeholder="Note" required></textarea>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('sentence.Close') }}</button>
          <button class="btn btn-primary text-white" type="submit">{{ __('sentence.Save') }}</button>
          </form>
        </div>
      </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
   <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
   <!-- Include Required Prerequisites -->
   <!-- <script src="code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script> -->


<!--        
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
          <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>

          <script type="text/javascript">
  new DataTable('#example',{
    order: [[0, 'asc']]
  });
 
</script>         -->
@endsection

@section('header')
<link rel="stylesheet" href="{{ asset('dashboard/css/lightbox.css') }}" />
@endsection
@section('footer')
<script type="text/javascript" src="{{ asset('dashboard/js/lightbox.js') }}"></script>
@endsection