<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
<!-- <h1>DICOM MODALITY</h1> -->


<?php $__env->startSection('title'); ?>
Add Findings
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- SUMMERNOTE CDN -->
   <!-- include libraries(jQuery, bootstrap) -->
   <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"> -->
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

   
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js" defer></script>

   
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
<style>
   .select2-container--default .select2-selection--single {
    padding: 4px;
    height: initial;
}
   </style>
<!-- SUMMERNOTE CDN -->

<!-- ****************SWEETALERT**************** -->
<script src="<?php echo e(asset('npm/sweetalert2@11.js')); ?>"></script>
<?php if($reportId != null): ?>
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
<?php endif; ?>
<!-- ****************SWEETALERT**************** -->

<div class="col-12">
   <!-- <div class="col-md-10">-->
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <div class="row">
            <div class="col-8">
               <h6 class="m-0 font-weight-bold text-primary"><?php echo e($title); ?></h6>
            </div>
            <div class="col-4 text-right">
               <a href="/dicom/patient/all" class="btn btn-info">Dicom List</a>
            </div>
         </div>
      </div>
      <div class="card-body">
         <div class="row" style="width: 100%; height: 100%;">

            <div class="col-sm-12">
               <form method="post" action="<?php echo e(route('patient.result.store', ['id' => $id] )); ?>">
                  <?php echo csrf_field(); ?>
                  <input type="hidden" value="<?php echo e($results->StudyInsta); ?>" name="study_instance">
                  <input type="hidden" value="<?php echo e($id); ?>" name="id">
                  <?php if(isset($results->created_by)): ?>
                  <input type="hidden" value="<?php echo e($results->created_by); ?>" name="created_by">
                  <?php endif; ?>
                  <?php if(isset($results->dicom_patient_id)): ?>
                  <input type="hidden" value="<?php echo e($results->dicom_patient_id); ?>" name="update_patient_id">
                  <?php endif; ?>
                  <div class="form-group row">
                     <div class="col-md-3">
                        <label for="name">Last Name<font color="red">*</font></label>
                        <input type="text" class="form-control" id="Name" name="name" value="<?php echo $patient_info['name']; ?>">
                     </div>
                     <div class="col-md-3">
                        <label for="name">First Name<font color="red">*</font></label>
                        <input type="text" class="form-control" id="FName" name="first_name" value="<?php echo $patient_info['first_name']; ?>">
                     </div>
                     <div class="col-md-3">
                        <!-- <label for="name">Middle Name<font color="red">*</font></label>
                        <input type="text" class="form-control" id="Mame" name="middle_name" value="<?php echo $patient_info['middle_name']; ?>"> -->
                     </div>
                     <div class="col-sm">
                        <label for="name">View Study</label></br>
                        <a href="http://www.hchdgte.com/viewer?StudyInstanceUIDs=<?php echo e($results->StudyInsta); ?>" target="_blank" class="btn btn-outline-warning btn-md" title="View Study"><img class="fa grey" width="16" src="<?php echo e(asset('webfonts/x-ray-solid.svg')); ?>" /> </a>
                     </div>
                     <div class="col-sm">
                        <label for="plateNumber">Series No.</label>
                        <input type="text" class="form-control" readonly id="SeriesNum" name="series_num" value="<?php echo e($results->SeriesNumb); ?>">
                     </div>
                  </div>
                  <div class="form-group row">
                  <div class="col-sm">
                        <label for="patientID">Patient No.</label>
                        <input type="text" class="form-control" id="patientID" name="dicom_patient_id" value="<?php echo $results->PatientID ?>">
                     </div>
                     <div class="col-sm">
                        <label for="age">Age</label>
                        <input type="text" class="form-control" id="age" name="age" value="<?php echo e(\Carbon\Carbon::parse($patient_info['birthday'])->age); ?>">
                     </div>
                     <div class="col-sm">
                        <label for="sex">Sex<font color="red">*</font></label>
                        <input type="text" class="form-control" id="sex" name="sex" value="<?php echo e($patient_info['gender']); ?>">
                     </div>
                     <div class="col-sm">
                        <label for="birthDate">Birthdate</label>
                        <input type="text" class="form-control" id="birthDate" name="birthday" value="<?php echo date("M d Y", strtotime($patient_info['birthday'])); ?>">
                     </div>
                  </div>
                  <div class="form-group row">
                    
                     <div class="col-sm">
                        <label for="datePerformed">Date Captured</label>
                        <input type="text" class="form-control" readonly id="StudyDate" name="study_date" autocomplete="off" value="<?php echo date("M d Y", strtotime($results->StudyDate)); ?> <?php echo e(\Carbon\Carbon::parse($results->StudyTime)->format('g:i A')); ?>">
                     </div>
                     <div class="col-sm">
                        <label for="cs">Department</label>
                        <input type="text" readonly class="form-control" id="ReferingPhys" name="refering_phys" value=" <?php if(isset($results->ReferingPhysi)): ?> $results->ReferingPhysi <?php endif; ?>" >
                     </div>
                     <div class="col-sm">
                        <label for="patientID">Series Description</label>
                        <input type="text" class="form-control" readonly id="SeriesDesc" name="series_desc" value="<?php echo $results->SeriesDesc ?>">
                     </div>
                     <div class="col-sm">
                        <label for="roomNumber">Body Part</label>
                        <input type="text" class="form-control" readonly id="BodyPart" name="body_part" value="<?php echo $results->BodyPartEx ?>">
                     </div>
                     <div class="col-sm">
                        <label for="examNumber">Study Modality</label>
                        <?php $modality = '';?>
                        <?php if(isset($results->modality)): ?>
                        <?php  $modality = $results->modality; ?>
                          <?php endif; ?>
                        <input type="text" class="form-control" id="Modality" name="modality" value="<?php echo e($modality); ?> <?php echo e($patient_info['study_modality']); ?>">
                     </div>
                     <div class="col-sm">
                        <label for="examNumber">Exam No.<font color="red">*</font></label>
                        <input type="text" class="form-control" id="examNumber" name="exam_number" value="4">
                     </div>
                  </div>
                  <hr>
                  <div class="form-group row">
                     <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                     </div>
                     <div class="alert alert-success print-success-msg" style="display:none">
                        <ul></ul>
                     </div>
<!-- SUMMERNOTE -->
<div class="col-sm-12">
                        <textarea class="form-control" name="findings" id="summernote" autofocus>
                           <?php if(isset( $findings[0]->findings)): ?>
                                 <?php echo e($findings[0]->findings); ?>

                           <?php endif; ?>
                              </textarea>
                     </div>
<!-- SUMMERNOTE -->
<!-- ************************************* -->
                     <!-- <div class="table-responsive">
                        <table class="table table-bordered" id="dynamic_field">
                           <thead>
                              <tr>
                                 <td>Test</td>
                                 <td>Choose Defined Value</td>
                                 <td></td>
                                 <td>Findings</td>
                                 <td>Impressions</td>
                                 <td></td>
                              </tr>
                           </thead>
                           <tr>
                              <td>
                                 <input type="hidden" id="txtIndex" name="txtIndex" value="0">
                                 <select class="form-control" name="test[]" id="test" required>
                                    <option hidden><?php echo e(__('sentence.Select Test')); ?>...</option>
                                    <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php if( isset($results->test_id) && $results->test_id ==  $test->id): ?>
                                       <option value="<?php echo e($test->id); ?>" selected ><?php echo e($test->test_name); ?></option>
                                       <?php else: ?>
                                       <option value="<?php echo e($test->id); ?>" ><?php echo e($test->test_name); ?></option>
                                       <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </select>
                              </td>
                              <td style="width:20%;">
                                 <div class="row">
                                    <div class="col-sm w-10">
                                       <select class="form-control" name="defaults[]" multiple="" autocomplete="false">
                                          <option value="negative">N E G A T I V E </option>
                                          <option value="Lines and Tube: None.">Lines and Tube: None.</option>
                                          <option value="Lungs and Pleura: Lungs are clear. No pneumothorax or pleural effusion.">Lungs and Pleura: Lungs are clear. No pneumothorax or pleural effusion.</option>
                                          <option value="Heart and Mediastinum: Cardiomediastinal silhouette is within normal limits.">Heart and Mediastinum: Cardiomediastinal silhouette is within normal limits.</option>
                                          <option value="javascript">Bones: Visualized osseous structures are unremarkable.</option>

                                       </select>
                                    </div>
                              </td>
                              <td>
                                 <div class="col-sm">
                                    <button type="button" class="btn btn-sm btn-info">
                                       >>
                                    </button>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <textarea class="form-control" placeholder="Type here....." name="findings[]" autocomplete="false"></textarea>

                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <textarea class="form-control" placeholder="Type here....." name="impressions[]" autocomplete="false"></textarea>
                                 </div>
                              </td id="td1">
                              <td><button type="button" name="add" id="add_findings" class="btn btn-sm btn-success">+More</button></td>
                           </tr>
                        </table>

                     </div> -->
<!-- *********************************** -->
                  </div>

                  <div class="form-group row">
                     <!-- <div class="col-sm">
                        <label for="examination">Physician</label>
                        <input type="text" class="form-control" id="physician" name="created_by">
                     </div> -->
                     <div class="form-group col-sm-4">
                     <label for="Physician">Physician</label>
                     <select class="form-control physician-dropdown text-uppercase" name="physician_id" id="Physician">
                        <option value="">Choose</option>
                        <?php $physician_id =''; 
                        $refered = '';
                        if(isset($results->physician_id)){
                           $physician_id = $results->physician_id;
                        }
                        if(isset($refered_phys)){
                           $refered= $refered_phys;
                        }
                        ?>
                           
                     <?php $__currentLoopData = $physicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $physician): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                          
                           <?php if($physician->id == $physician_id): ?>  <!--Physician from Update -->
                           <option value="<?php echo e($physician->id); ?>" selected>[<?php echo e($physician->title); ?>] <?php echo e($physician->name); ?>, <?php echo e($physician->first_name); ?> <?php echo e($physician->middle_name); ?> <?php echo e($physician->position); ?></option>
                           <?php elseif($physician->id == $refered): ?>  <!-- Assign Physician on New Result -->
                           <option value="<?php echo e($physician->id); ?>" selected>[<?php echo e($physician->title); ?>] <?php echo e($physician->name); ?>, <?php echo e($physician->first_name); ?> <?php echo e($physician->middle_name); ?> <?php echo e($physician->position); ?></option>
                           <?php else: ?>
                           <option value="<?php echo e($physician->id); ?>">[<?php echo e($physician->title); ?>] <?php echo e($physician->name); ?>, <?php echo e($physician->first_name); ?> <?php echo e($physician->middle_name); ?> <?php echo e($physician->position); ?></option>
                           <?php endif; ?>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                     </select>

                     
                  </div>
                     <div class="col-sm-4">
                        <label for="examination">Created Date</label>
                        <input type="text" class="form-control" id="date" readonly name="date" value="<?php echo e(date('M d Y h:m a' )); ?>">
                     </div>
                  </div>
<p><?php
// echo json_encode($physicians); 
//echo json_encode($refered);
?></p> 
                  <div class="form-group row">
                     <div class="col-sm-12 p-2 text-right mt-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                     </div>
                  </div>
               </form>
               <!-- ***************FORM*************** -->
               <!-- </div> -->
            </div>
         </div>
         <!-- </div>
      </div>
   </div> -->
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
      <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>  -->
<!-- SUMMERNOTE CDN -->
   <!-- include summernote css/js -->
   <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<!-- SUMMERNOTE CDN -->
      <script>
                  $('#summernote').summernote({
                     placeholder: 'Enter Description',
                     height: 250,                     
                     toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']]
                     ],
                     popover: {
                           air: [
                              ['font', ['strikethrough', 'superscript', 'subscript']],
                              ['fontsize', ['fontsize']],
                              ['color', ['color']],
                              ['para', ['ul', 'ol', 'paragraph']],
                              ['height', ['height']]
                           ]
                        },
                       //codemirror: { // codemirror options
                           theme: 'monokai'
                       // }
                  });
                  $('#summernote').summernote('focus');

         $(document).ready(function() {
            $('#test').on('change', function() {
               var testID = $(this).val();
               if (testID) {
                  $.ajax({
                     url: 'getExam/' + testID,
                     type: "POST",
                     data: {
                        "_token": "<?php echo e(csrf_token()); ?>"
                     },
                     dataType: "json",
                     success: function(data) {
                        if (data) {
                           $('#exam').empty();
                           $('#exam').append('<option hidden>Choose Examination</option>');
                           $.each(data, function(key, course) {
                              $('select[name="examination"]').append('<option value="' + key + '">' + exam.name + '</option>');
                           });
                        } else {
                           $('#exam').empty();
                        }
                     }
                  });
               } else {
                  $('#exam').empty();
               }
            });
         });
      
$(document).ready(function() {
    $('#Physician').select2();
});
</script>


      <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hch\resources\views/dicom/view_modality.blade.php ENDPATH**/ ?>