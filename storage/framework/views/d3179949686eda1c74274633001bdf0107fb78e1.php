<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HCH Viewer App - Print Result</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="<?php echo e(asset('css/print.css')); ?>" rel="stylesheet"  media="print">


    <style>
/* ******************************** */

/*-----start print layout---*/
.content ,
.content-wrapper{
    background-color: #c9c9c9;
}

.page-container{
    background: #fff;
    width: 8.5in;
    margin: 0.5in auto 0.5in auto;
    margin-right: auto;
    padding: 0.5in;
}

.header {
    visibility: hidden;
    width: 100%;
	height: 10px;
    background: #fff;
    position: fixed;
    top: 0px;
    left: 0;
    z-index: 99999999 !important;

   /* text-align: center; */
}
.header p {
    font-size: 12px;
}
.footer {
    visibility: hidden;
    width: 100%;
	height: 120px;
    position: fixed;
    bottom: 0px;
    left: 0;
    background: #fff;
    z-index: 99999999 !important;
    text-align: left;
}

.print-only {
    display: none !important;
}

.headerGroup {
	position: relative;
	background: transparent;
}

.headerGroup:after {
	font-size: 42px;
    color: #f50000;
    text-align: center;
    filter: grayscale(0.5);
    background-size: cover;
    opacity: .2;
    position: absolute;
    top: 350px;
    left: 50%;
    width: 450px;
    height: 450px;
    z-index: 1 !important;
    transform: translate(-50%);
    display: none;
}

/* ============media start========== */
@media  print {




    #divImage {
                position: fixed;
               /* bottom: 30px;*/
                width: 100%;
                float: left;
                margin-bottom: 80px;
            }
            #footerSig{
                margin-top: 20px;
            }
            #footerSig2nd{
                margin-top: 0px;
            }

    #imageSign{
                mix-blend-mode: multiply;
                /* position: fixed;
                bottom: 0;
                width: 15%;
                margin-bottom: 18%; */
 
    }
    #imageSign2nd{
                mix-blend-mode: multiply;
                position: fixed;
                bottom: 0;
                /* width: 15%; */
                margin-bottom: 12%;
    }

    .page-container{
        background: #fff;
        margin: 0;
        padding: 0;
    }

	.headerGroup:after {
        filter: grayscale(0);
        display: inline-block;
		opacity: .2;
		width:700px !important;
	}
	.content ,
    .content-wrapper{
		padding: 2px!important;
		margin: 0 !important;
		background-color: #ffffff;

	}

    .header, 
    .header-block {
        height: 120px;
		background-color: #fff;
		padding: 0;
		margin: 0;
    }
    .footer, 
    .footer-block {
        height: 100px;
		background-color: none;
    }

    footer {
        page-break-after: always;
		height: 120px !important;
    }
    @page  {
        size: A4;
        -webkit-print-color-adjust: exact;
        margin: 0 !important;
        margin-top: 30px !important;
		padding:0 !important;
		width: 100%;
		height: 100%;
    }
    thead {
        display: table-header-group;
    }
    tfoot {
        display: table-footer-group;
    }
    .invoice-print {
        width: 95%;
    }
    .header {
        visibility: visible;
    }
    .footer {
        visibility: visible;
    }
      html, body {
        border: 1px solid white;
        height: 99%;
        page-break-after: avoid;
        page-break-before: avoid;
    }
    /* ----for content management in print layout---- */
    .no-print {
        display: none !important;
    }
    .print-only {
        display: block !important;
    }
    /* ----aditional style----- */
    .page{
        margin-right:2rem;
        margin-left: 2rem;
    }

}
/* ==============end print=========== */
/* ================================== */
/* ************************************ */
    /* .headerGroup:after {
        content: 'CONFIDENTIAL';
        background-image: url('Moto-invoice-setup-96-watter-mark.jpg');

    } */
</style>


</head>

<body>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="height: 30%;padding-bottom: 35px!important;">
        <table width="100%">
            <thead>
                <tr>
                    <td class="headerGroup">
                        <div class="header-block">
                            <!-- <button type="button" onclick="window.print();" class="btn btn-sm btn-primary px-4 py-2 m-4">Print</button> -->
                        </div>
                    </td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td class="footerGroup">
                        <div class="footer-block"></div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>
                        <div class="page-container">

                            <div class="page">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <!-- <td> SN </td> -->
                                            <td>
                                                    <div style="width: 100%;padding: 10px;">
                                                    <center><span><b>DEPARTMENT OF RADIOLOGY</b></span></center>
                                                    </div>
                                        
                                                    <div class="row">
                                                        <div class="text-left col"><span>Name: </span><b><span class=" text-uppercase"><?php echo $results->name . ", " . $results->first_name; ?></b></span></div>
                                                        <div class="text-end col" >Patient No: <b><?php echo e($results->dicom_patient_id); ?></b></div>
                                                        <!-- <div class="text-right col-sm">Room No.:<b></b></div> -->
                                                    </div>
                                        
                                                    <div class="row">
                                                        <div class="text-left col-sm-3">Birhdate: <b><?php echo e($results->birthday); ?></b></div>
                                                        <div class="text-left col-sm-5"><span>Age: <b><?php echo e(\Carbon\Carbon::parse($results->birthday)->age); ?></b></span></div>
                                                        <div class="text-end col-sm-4">Sex: <b><?php echo e($results->gender); ?></b></div>
                                                        <!-- <div class="col-sm-2">Exam No.: <b></b></div> -->
                                                    </div>

                                                    <div class="row">                                                                                            
                                                        <!-- <div class="col-sm-4">Case No.: <b><?php echo e($results->case_no); ?></b></div> -->
                                                         <!-- <div class="col-sm-2"><span>C.S.: <b><?php echo e($results->cs); ?></b></span></div> -->
                                                        <div class="text-left col-sm-6 ">Captured Date.: <b><?php echo e(\Carbon\Carbon::parse($results->study_date)->format('M d Y')); ?></b></div>
                                                        <!-- <div class="text-left col-sm-4"><span>Result Date: <b> <?php echo e(\Carbon\Carbon::parse($results->created_at)->format('M d Y')); ?></b></span></div> -->
                                                        <div class="text-end col-sm-6"><span>Result Date: <b> <?php echo e(\Carbon\Carbon::parse($results->result_table_created_at)->format('M d Y')); ?></b></span></div>

                                                    </div>

                                                    <div class="row display-inline">                                                         
                                                            <?php if($results->refering_phys): ?>
                                                            <div class="text-left col-sm-8">Referring Physician: <b><?php echo e($refering_phys->name); ?>, <?php echo e($refering_phys->first_name); ?> <?php echo e($refering_phys->middle_name); ?> - <?php echo e($refering_phys->position); ?></b></div>
                                                            <?php else: ?>
                                                            <div class="text-left col-sm-8">Referring Physician:</div>
                                                            <?php endif; ?>
                                                            <!-- <div class="text-left col-sm-3">Body Part: <b><?php echo e($results->body_part); ?></b></div> -->
                                                        <div class="text-end col-sm-4">Examination: <b></b></div>
                                                    </div>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border-top">
                                                    <!-- <div style="width: 100%;">
                                                    <center><span><b>DEPARTMENT OF RADIOLOGY</b></span></center>
                                                    </div>
                                        
                                                    <div class="row">
                                                        <div class="text-left col-sm"><span>Name: <b><?php // echo $results->name . " " . $results->first_name . " " . $results->middle_name; ?></b></span></div>
                                                        <div class="col-sm">Patient:<b></b></div>
                                                        <div class="text-right col-sm">Room No.:<b></b></div>
                                                    </div>
                                        
                                                    <div class="row">
                                                        <div class="text-left col-sm-6"><span>Date Performed: <b><?php echo e($results->result_table_created_at); ?></b></span></div>
                                                        <div class="col-sm-3">Exam No.: <b></b></div>
                                                        <div class="text-right col-sm-3">Case No.: <b><?php echo e($results->case_no); ?></b></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="text-left col-sm-2"><span>Age: <b></b></span></div>
                                                        <div class="col-sm-2">Sex: <b><?php echo e($results->gender); ?></b></div>
                                                        <div class="col-sm-3">B-Day: <b><?php echo e($results->birthday); ?></b></div>
                                                        <div class="col-sm-2"><span>C.S.: <b><?php echo e($results->cs); ?></b></span></div>
                                                        <div class="text-right col-sm-3">Plate No.: <b><?php echo e($results->plate_no); ?></b></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="text-left col-sm-6">Examination: <b></b></div>
                                                        <div class="text-right col-sm-6">Patient No: <b><?php echo e($results->dp_id); ?></b></div><br>
                                                    </div> -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <?php echo $findings[0]->findings; ?>                         
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>

                                            <!-- <div class="row">
                                                <div class="col-sm-6"></div>
                                                <div class="text-center col-sm-6">
                                                    <div id="footerSig" >
                                                        <img src="<?php echo e(asset('uploads/' . $results->esign)); ?>" id="imageSign" alt="esign" width="80px" height="60px">
                                                        <p><?php echo e($results->user_name); ?>, <?php echo e($results->user_first_name); ?> <?php echo e($results->user_middle_name); ?> <?php echo e($results->user_position); ?><br><span class="font-weight-normal">Radiologist</span></p>
                                                    </div>
                                                </div>
                                            </div>         -->
                                            <br><br><br>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ============ srtart absolute header/footer image========== -->
    <div class="header" style="position: fix; margin: 10px 0;">
        <!-- <img src="Moto-invoice-setup-96-Header.jpg" alt="header image" width="100%" height="120px"
            style="float:left; background-size: cover;"> -->
            <div id="divImage" class="row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-2 text-right">
                <img class="" src="<?php echo e(asset('image.png')); ?>" id="image"  alt="test" width="100px" height="100px">
                </div>
            </div>
                <div class="col-sm-12 text-center">
                    <h3>HOLY CHILD HOSPITAL</h3>
                    <p>Bishop Epifanio Surban Street, <br>
                    6200 Dumaguete City, Philippines<br>
                    Phone: (035) 225-0510;
                    email: holychild65@yahoo.com</p>
                </div>
                <!-- <div class="col-sm-1">
                </div> -->
            
    </div>
    <!-- <div class="footer">
        <img src="Moto-invoice-setup-96-Footer.jpg" alt="Footer image" width="100%" height="100px"
            style="float:left; background-size: cover;">
    </div> -->
    <div class="footer">
    
                        
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="text-center col-sm-6">

            <div class="float-center">
                <img src="<?php echo e(asset('uploads/' . $results->esign)); ?>" id="imageSign2nd" alt="esign" width="80px" height="60px">
            </div>
                <div id="footerSig2nd">
                <p><?php echo e($results->user_name); ?>, <?php echo e($results->user_first_name); ?> <?php echo e($results->user_middle_name); ?> <?php echo e($results->user_position); ?><br><span class="font-weight-normal">Radiologist</span></p>
                    <!-- <p><?php echo e($results->user_name); ?>

                        <br>Radiologist</p> -->
                </div>
            </div>

        </div>  

    </div>    
    <!-- ============ end absolute header/footer image========== -->

    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
        

</body>
<script type="text/javascript">
      window.onload = function() { 
        window.print(); 
        setTimeout(window.close, 0);
    }
 </script>
</html><?php /**PATH C:\xampp\htdocs\hch\resources\views/dicom/print_report.blade.php ENDPATH**/ ?>