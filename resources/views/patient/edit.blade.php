@extends('layouts.master')
@section('title')
{{ __('sentence.Edit Patient') }}
@endsection
@section('content')
<script src="{{ asset('npm/sweetalert2@11.js') }}"></script>

<!-- <link href= "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet" /> 
<script src="https://code.jquery.com/jquery-1.10.2.js"></script> 
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>  -->

<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css"> -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>

<script>
  $( function() {
    $( "#datepicker" ).datepicker({
      				dateFormat: "M dd yy", 
				monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "Maj", 
					"Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] 
    });
  });
  </script>

<input type="text" class="form-control"  id="datepicker" >

<div class="row justify-content-center">
   <div class="col-md-10">
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            
            <div class="row">
                <div class="col-8">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('sentence.Edit Patient') }}</h6>
                </div>
                <div class="col-4">
                  @can('view patient')
                  <a href="{{ route('patient.view', ['id' => $patient->id]) }}" class="btn btn-primary btn-sm float-right "><i class="fa fa-eye"></i> {{ __('sentence.View Patient') }}</a>
                  @endcan
                </div>
              </div>
         </div>
         <div class="card-body">
            <form method="post" action="{{ route('patient.store_edit') }}" enctype="multipart/form-data">
               @csrf
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="inputEmail4">Last Name<font color="red">*</font></label>
                     <input type="text" class="form-control" id="Name" name="name" value="{{ $patient->name }}">
                     <input type="hidden" class="form-control" name="id" value="{{ $patient->id }}">
                  </div>
                  <div class="form-group col-md-3">
                     <label for="inputEmail4">First Name</label>
                     <input type="text" class="form-control" id="FName" name="first_name"  value="{{ $patient->first_name }}">
                  </div>
                  <div class="form-group col-md-3">
                     <label for="inputEmail4">Middle Name</label>
                     <input type="text" class="form-control" id="MName" name="middle_name"  value="{{ $patient->middle_name }}">
                  </div>
                 
               </div>
               <div class="form-row">
                  
               <!-- <div class="form-group col-md-4">
                     <label for="inputPassword4">{{ __('sentence.Email Adress') }}</label>
                     <input type="email" class="form-control" id="Email" name="email" value="{{ $patient->email }}">
                  </div> -->
                  <div class="form-group col-md-4">
                     <label for="inputAddress2">{{ __('sentence.Phone') }}</label>
                     <input type="text" class="form-control" id="Phone" name="phone" value="{{ $patient->phone }}">
                  </div>
                  <div class="form-group col-md-4">
                     <label for="inputAddress">{{ __('sentence.Birthday') }}<font color="red">*</font></label>
                     <!-- <input type="date" class="form-control" id="Birthday" name="birthday"  value="{{ $patient->birthday }}"> -->
                     <input type="text" class="form-control" id="Birthday" name="birthday"  value="{{ $patient->birthday }}">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="inputAddress2">{{ __('sentence.Address') }}</label>
                     <input type="text" class="form-control" id="Address" name="adress" value="{{ $patient->address }}">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="inputCity">{{ __('sentence.Gender') }}<font color="red">*</font></label>
                     <select class="form-control" name="gender" id="Gender">
                        
                        <!-- <option value="{{ $patient->gender }}" selected="selected">{{ $patient->gender }}</option> -->
                     
                        <option value="M" <?php if($patient->gender == 'M'){ echo "selected='selected'"; } ?> >{{ __('sentence.Male') }}</option>
                        <option value="F" <?php if($patient->gender == 'F'){ echo "selected='selected'"; } ?> >{{ __('sentence.Female') }}</option>
                        
                     </select>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="inputZip">{{ __('sentence.Blood Group') }}</label>
                     <select class="form-control" name="blood" id="Blood">
                        @if($patient->blood != null)
                        <option value="{{ $patient->blood }}" selected="selected">{{ $patient->blood }}</option>
                        @elseif($patient->blood == null)
                        <option value="Unknown" selected="selected">{{ __('sentence.Unknown') }}</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        @endif
                     </select>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="inputAddress2">{{ __('sentence.Patient Weight') }}</label>
                     <input type="text" class="form-control" id="Weight" name="weight" value="{{ $patient->weight }}">
                  </div>
                  <div class="form-group col-md-6">
                     <label for="inputAddress">{{ __('sentence.Patient Height') }}<font color="red">*</font></label>
                     <input type="text" class="form-control" id="height" name="height" value="{{ $patient->height }}">
                  </div>
               </div>
               <!-- <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="inputState">{{ __('sentence.Image') }}</label>
                     <label for="file-upload" class="custom-file-upload">
                     <i class="fa fa-cloud-upload"></i> Select Image to Upload
                     </label>
                     <input type="file" class="form-control" id="file-upload" name="image">
                  </div>
               </div> -->
               <div class="form-group row">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-primary">{{ __('sentence.Save') }}</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


@endsection
@section('header')
<style type="text/css">
   input[type="file"] {
   display: none;
   }
   .custom-file-upload {
   border: 1px solid #ccc;
   display: inline-block;
   padding: 6px 12px;
   cursor: pointer;
   }
</style>
@endsection
@section('footer')
@endsection