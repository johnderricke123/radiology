<?php $__env->startSection('title'); ?>
<?php echo e(__('sentence.Edit Patient')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<script src="<?php echo e(asset('npm/sweetalert2@11.js')); ?>"></script>

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
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('sentence.Edit Patient')); ?></h6>
                </div>
                <div class="col-4">
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view patient')): ?>
                  <a href="<?php echo e(route('patient.view', ['id' => $patient->id])); ?>" class="btn btn-primary btn-sm float-right "><i class="fa fa-eye"></i> <?php echo e(__('sentence.View Patient')); ?></a>
                  <?php endif; ?>
                </div>
              </div>
         </div>
         <div class="card-body">
            <form method="post" action="<?php echo e(route('patient.store_edit')); ?>" enctype="multipart/form-data">
               <?php echo csrf_field(); ?>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="inputEmail4">Last Name<font color="red">*</font></label>
                     <input type="text" class="form-control" id="Name" name="name" value="<?php echo e($patient->name); ?>">
                     <input type="hidden" class="form-control" name="id" value="<?php echo e($patient->id); ?>">
                  </div>
                  <div class="form-group col-md-3">
                     <label for="inputEmail4">First Name</label>
                     <input type="text" class="form-control" id="FName" name="first_name"  value="<?php echo e($patient->first_name); ?>">
                  </div>
                  <div class="form-group col-md-3">
                     <label for="inputEmail4">Middle Name</label>
                     <input type="text" class="form-control" id="MName" name="middle_name"  value="<?php echo e($patient->middle_name); ?>">
                  </div>
                 
               </div>
               <div class="form-row">
                  
               <!-- <div class="form-group col-md-4">
                     <label for="inputPassword4"><?php echo e(__('sentence.Email Adress')); ?></label>
                     <input type="email" class="form-control" id="Email" name="email" value="<?php echo e($patient->email); ?>">
                  </div> -->
                  <div class="form-group col-md-4">
                     <label for="inputAddress2"><?php echo e(__('sentence.Phone')); ?></label>
                     <input type="text" class="form-control" id="Phone" name="phone" value="<?php echo e($patient->phone); ?>">
                  </div>
                  <div class="form-group col-md-4">
                     <label for="inputAddress"><?php echo e(__('sentence.Birthday')); ?><font color="red">*</font></label>
                     <!-- <input type="date" class="form-control" id="Birthday" name="birthday"  value="<?php echo e($patient->birthday); ?>"> -->
                     <input type="text" class="form-control" id="Birthday" name="birthday"  value="<?php echo e($patient->birthday); ?>">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="inputAddress2"><?php echo e(__('sentence.Address')); ?></label>
                     <input type="text" class="form-control" id="Address" name="adress" value="<?php echo e($patient->address); ?>">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="inputCity"><?php echo e(__('sentence.Gender')); ?><font color="red">*</font></label>
                     <select class="form-control" name="gender" id="Gender">
                        
                        <!-- <option value="<?php echo e($patient->gender); ?>" selected="selected"><?php echo e($patient->gender); ?></option> -->
                     
                        <option value="M" <?php if($patient->gender == 'M'){ echo "selected='selected'"; } ?> ><?php echo e(__('sentence.Male')); ?></option>
                        <option value="F" <?php if($patient->gender == 'F'){ echo "selected='selected'"; } ?> ><?php echo e(__('sentence.Female')); ?></option>
                        
                     </select>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="inputZip"><?php echo e(__('sentence.Blood Group')); ?></label>
                     <select class="form-control" name="blood" id="Blood">
                        <?php if($patient->blood != null): ?>
                        <option value="<?php echo e($patient->blood); ?>" selected="selected"><?php echo e($patient->blood); ?></option>
                        <?php elseif($patient->blood == null): ?>
                        <option value="Unknown" selected="selected"><?php echo e(__('sentence.Unknown')); ?></option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <?php endif; ?>
                     </select>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="inputAddress2"><?php echo e(__('sentence.Patient Weight')); ?></label>
                     <input type="text" class="form-control" id="Weight" name="weight" value="<?php echo e($patient->weight); ?>">
                  </div>
                  <div class="form-group col-md-6">
                     <label for="inputAddress"><?php echo e(__('sentence.Patient Height')); ?><font color="red">*</font></label>
                     <input type="text" class="form-control" id="height" name="height" value="<?php echo e($patient->height); ?>">
                  </div>
               </div>
               <!-- <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="inputState"><?php echo e(__('sentence.Image')); ?></label>
                     <label for="file-upload" class="custom-file-upload">
                     <i class="fa fa-cloud-upload"></i> Select Image to Upload
                     </label>
                     <input type="file" class="form-control" id="file-upload" name="image">
                  </div>
               </div> -->
               <div class="form-group row">
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-primary"><?php echo e(__('sentence.Save')); ?></button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hch\resources\views/patient/edit.blade.php ENDPATH**/ ?>