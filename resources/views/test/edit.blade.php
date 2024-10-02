@extends('layouts.master')

@section('title')
{{ __('sentence.Edit Test') }}
@endsection

@section('content')

<div class="row justify-content-center">
   <div class="col-md-10">
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('sentence.Edit Test') }}</h6>
         </div>
         <div class="card-body">
            <form method="post" action="{{ route('test.store_edit') }}">
               <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 col-form-label">{{ __('sentence.Test Name') }}<font color="red">*</font></label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control" id="inputEmail3" name="test_name" value="{{ $test->test_name }}">
                     {{ csrf_field() }}
                  </div>
               </div>
               <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-3 col-form-label">{{ __('sentence.Description') }}</label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control" id="inputPassword3" name="comment" value="{{ $test->comment }}">
                     <input type="hidden" name="test_id" value="{{ $test->id }}">
                  </div>
               </div>
               <div class="form-group row">
                  <h5>
                    Produres
                  </h5>
               </div>
               <div class="table-responsive">
                  <table class="table table-bordered" id="dynamic_field">
                     <thead>
                     <tr>
                        <td>Name</td>
                        <td>Input Type</td>
                        <td>Unit</td>
                        <td>Range</td>
                        <td>Short Name</td>
                        <td></td>
                     </tr>
                     </thead>
                     <?php $cnt = 0; ?>
                     <tr id="row{{ $cnt }}" class="dynamic-added">
                           <td><input type="text" name="name[]" placeholder="Enter Exam Name" class="form-control name_list" required/></td>
                           <td><input type="text" name="input_type[]" placeholder="Enter Input Type" class="form-control name_list" /></td>
                           <td><input type="text" name="unit[]" placeholder="Enter Unit" class="form-control name_list" /></td>
                           <td><input type="text" name="range[]" placeholder="Enter Range" class="form-control name_list" /></td>
                           <td><input type="text" name="short_code[]" placeholder="Short Name" class="form-control name_list" /></td>
                           <td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td>
                        </tr>
                       
                       

                        @foreach($exams as $exam)
                        <?php $cnt++; ?>
                        <tr id="row{{ $cnt }}" class="dynamic-added">
                           <td><input type="text" name="name[]" placeholder="Enter Exam Name" class="form-control name_list" required value="{{ $exam->name }}"/></td>
                           <td><input type="text" name="input_type[]" placeholder="Enter Input Type" class="form-control name_list" /></td>
                           <td><input type="text" name="unit[]" placeholder="Enter Unit" class="form-control name_list" /></td>
                           <td><input type="text" name="range[]" placeholder="Enter Range" class="form-control name_list" /></td>
                           <td><input type="text" name="short_code[]" placeholder="Short Name" class="form-control name_list" /></td>
                           <?php if($cnt < 1) { ?>
                           <td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td>
                           <?php } else { ?>
                           <td><button type="button" name="remove" id="{{ $cnt }}" class="btn btn-danger btn_remove">X</button></td>
                         <?php  } ?>
                        </tr>
                          
                              @endforeach
                             
                  </table>

               </div>



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

@endsection

@section('footer')

@endsection