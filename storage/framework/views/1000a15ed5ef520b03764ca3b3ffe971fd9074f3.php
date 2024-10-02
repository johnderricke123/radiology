<link rel="yandex-tableau-widget" href="/assets/yandex-browser-manifest.json"/>
	<script rel="preload" as="script" src="../js/app-config.js"></script>
	<script rel="preload" as="script" type="module" src="../js/init-service-worker.js"></script>
	<title>HCH Viewer</title>
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
	<link href="https://fonts.googleapis.com/css?family=Inter:100,300,400,500,700&display=swap" rel="stylesheet" rel="preload" as="style"/>

<?php $__env->startSection('title'); ?>
<?php echo e(__('sentence.All Patients')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
               <div class="row">
                <div class="col-6">
                    <h6 class="m-0 font-weight-bold text-primary w-75 p-2"><i class="fas fa-fw fa-user-injured"></i> <?php echo e(__('sentence.All Patients')); ?></h6>
                </div>
                <div class="col-4">
                 <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="<?php echo e(route('patient.search')); ?>" method="post">
                        <div class="input-group">
                            <input type="text" name="term" class="form-control border-1 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <?php echo csrf_field(); ?>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-2">
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add patient')): ?>
                  <a href="<?php echo e(route('patient.create')); ?>" class="btn btn-primary btn-sm float-right "><i class="fa fa-plus"></i> <?php echo e(__('sentence.New Patient')); ?></a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table stripe" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Date Added</th>
                      <th><?php echo e(__('sentence.Patient Name')); ?></th>
                      <th>First Name</th>
                      <th>Middle Name</th>
                      <th class="text-center"><?php echo e(__('sentence.Age')); ?></th>
                      <th class="text-center"><?php echo e(__('sentence.Gender')); ?></th>
                      <!-- <th class="text-center"><?php echo e(__('sentence.Blood Group')); ?></th> -->
                      <!-- <th class="text-center"><?php echo e(__('sentence.Date')); ?></th>
                      <th class="text-center"><?php echo e(__('sentence.Due Balance')); ?></th> -->
                      <th class="text-center">DICOM</th>
                      <!-- <th class="text-center"><?php echo e(__('sentence.Prescriptions')); ?></th> -->
                      <th class="text-center"><?php echo e(__('sentence.Actions')); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                      <td><label class="badge badge-primary-soft"><?php echo e(\Carbon\Carbon::parse($patient->created_at)->format('d M Y g:i A')); ?></label></td>
                      <td><a href="<?php echo e(url('patient/view/'.$patient->id)); ?>"> <?php echo e($patient->name); ?> </a></td>
                      <td><a href="<?php echo e(url('patient/view/'.$patient->id)); ?>"> <?php echo e($patient->first_name); ?> </a></td>
                      <td><a href="<?php echo e(url('patient/view/'.$patient->id)); ?>"> <?php echo e($patient->middle_name); ?> </a></td>
                      <td class="text-center"> <?php echo e(@\Carbon\Carbon::parse($patient->birthday)->age); ?> </td>
                      <td class="text-center"> <?php echo e(@$patient->gender); ?> </td>
                      <!-- <td class="text-center"> <?php echo e(@$patient->blood); ?> </td> -->
                      <!-- <td class="text-center"><label class="badge badge-primary-soft"><?php echo e($patient->created_at->format('d M Y H:i')); ?></label></td> -->
                      <!-- <td class="text-center"><label class="badge badge-primary-soft"><?php echo e(Collect($patient->Billings)->where('payment_status','Partially Paid')->sum('due_amount')); ?> <?php echo e(App\Setting::get_option('currency')); ?></label></td> -->
                      <!-- <td class="text-center"></td> -->
                      <td class="text-center">
                      <label class="badge badge-primary-soft">
                        <?php echo e(count($patient->Result)); ?> Results
                     </label>                       
                      </td>
                      <td class="text-center">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view patient')): ?>
                        <a href="<?php echo e(route('patient.view', ['id' => $patient->id])); ?>" class="btn btn-outline-success btn-circle btn-sm"><i class="fa fa-eye"></i></a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit patient')): ?>
                        <a href="<?php echo e(route('patient.edit', ['id' => $patient->id])); ?>" class="btn btn-outline-warning btn-circle btn-sm"><i class="fa fa-pen"></i></a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete patient')): ?>
                        <!-- <a href="#" class="btn btn-outline-danger btn-circle btn-sm" data-toggle="modal" data-target="#DeleteModal" data-link="<?php echo e(route('patient.destroy' , ['id' => $patient->id ])); ?>"><i class="fas fa-trash"></i></a> -->
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                      <td colspan="9"  align="center"><img src="<?php echo e(asset('img/rest.png')); ?> "/> <br><br> <b class="text-muted">No patients found!</b>
                        
                      </td>
                    </tr>
                    <?php endif; ?>
                   
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

<?php $__env->stopSection(); ?>

  
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hch\resources\views/patient/all.blade.php ENDPATH**/ ?>