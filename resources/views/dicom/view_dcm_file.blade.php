<!-- <link href="{{ asset('dashboard/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"rel="stylesheet" media="all">
    <link href="{{ asset('dashboard/css/sb-admin-2.min.css') }}" rel="stylesheet"  media="all">
    <link href="{{ asset('dashboard/css/gijgo.min.css') }}" rel="stylesheet" media="all">

<div class="row justify-content-center">
    <div class="row" style="width: 100%; height: 100%;">
        <div class="col-sm-9">
            <iframe src="http://localhost:5000/viewer?StudyInstanceUIDs=<?php echo $results->StudyInsta; ?>" style="width: 100%; height: 1000px;"></iframe>
        </div>
        <div class="col-sm-3">
            <form method="post" action="{{ route('generate.findings') }}">
                @csrf
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="name">Full Name<font color="red">*</font></label>
                        <input type="text" disabled class="form-control" id="Name" name="name" value="<?php echo $results->PatientNam; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm">
                        <label for="patientID">Patient No.</label>
                        <input type="text" class="form-control" disabled id="patientID" name="patientID" value="<?php echo $results->PatientID ?>">
                    </div>
                    <div class="col-sm">
                        <label for="datePerformed">Date Performed<font color="red">*</font></label>
                        <input type="text" class="form-control" disabled id="datePerformed" name="datePerformed" autocomplete="off" value="<?php echo date("M d Y", strtotime($results->StudyDate)); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm">
                        <label for="age">Age</label>
                        <input type="text" class="form-control" disabled id="age" name="age" value="{{$age}}">
                    </div>
                    <div class="col-sm">
                        <label for="sex">Sex<font color="red">*</font></label>
                        <input type="text" class="form-control" disabled id="sex" name="sex" value="<?php echo $results->PatientSex ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm">
                        <label for="birthDate">Birth Date</label>
                        <input type="text" class="form-control" disabled id="birthDate" name="birthDate" value="<?php echo date("M d Y", strtotime($results->PatientBir)); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-9 p-2">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="{{ asset('dashboard/js/vue.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/gijgo.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dashboard/js/jquery.repeatable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dashboard/js/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('https://jasonday.github.io/printThis/printThis.js') }}"></script>
    <script src="{{ asset('js/test.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script> -->




    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DICOM VIEWER</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            html,
            body {
                height: 100%;
            }

            /* .jumbotron {
                margin-top: 30px;
            } */

            #content,
            .sidebar {
                /* min-height: 650px; */
                height: 100%;
            }

            #row-main {
                overflow-x: hidden;
            }

            #content {
                background-color: black;

                /* -webkit-transition: width 0.3s ease;
                -moz-transition: width 0.3s ease;
                -o-transition: width 0.3s ease;
                transition: width 0.3s ease; */
            }

            #content .btn-group {
                margin-bottom: 10px;
            }

            .col-md-6 .width-9,
            .col-md-6 .width-12,
            .col-md-9 .width-6,
            .col-md-9 .width-12,
            .col-md-12 .width-6,
            .col-md-12 .width-9 {
                display: none;
            }

            .sidebar {
                /* background-color: lightgrey; */

                -webkit-transition: margin 0.3s ease;
                -moz-transition: margin 0.3s ease;
                -o-transition: margin 0.3s ease;
                transition: margin 0.3s ease;
            }

            .collapsed {
                display: none;
                /* hide it for small displays */
            }

            @media (min-width: 992px) {
                .collapsed {
                    display: block;
                }

                /* #sidebar-left.collapsed {
                    margin-left: -25%;
                } */

                #sidebar-right.collapsed {
                    margin-right: -25%;
                    /* same width as sidebar */
                }
            }

            /* #button1 {
                position: absolute !important;
                z-index: 10 !important;
                left: 0% !important;
                bottom: 50% !important;
                transform: rotate(90deg);
                -ms-transform: rotate(90deg);
                -moz-transform: rotate(90deg);
                -webkit-transform: rotate(90deg);
                -o-transform: rotate(90deg);
            } */

/* TESTING */
    *{padding:0;margin:0;}

    body{
        font-family:Verdana, Geneva, sans-serif;
        font-size:18px;
        background-color:#CCC;
    }

    .float{
        position:fixed;
        width:60px;
        height:60px;
        bottom:40px;
        right:40px;
        background-color:#0C9;
        color:#FFF;
        border-radius:50px;
        text-align:center;
        box-shadow: 2px 2px 3px #999;
    }

    .my-float{
        margin-top:22px;
    }
/* TESTING */

        </style>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body>
        <div class="container" style="width: 100%; height: 100%;">
                <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="jumbotron">
                                <h1>Bootstrap Collapsible Sidebars</h1>
                                <p>Using the Bootstrap grid system, some CSS and a little jQuery to create collapsible sidebars.</p>
                            </div>
                        </div>
                    </div> -->
            <div class="row" id="row-main" style="width: 100%; height: 100%;">
                <!-- <div class="col-md-3 sidebar collapsed" id="sidebar-left">
                </div> -->
                <div class="col-md-9" id="content" style="width: 75%; height: 100%;">
                <!-- <button type="button" class="btn btn-default toggle-sidebar-left">Toggle left</button> -->
                <div class="text-right col-12">
                    <button type="button" class="btn btn-default toggle-sidebar-right"><i class="fa fa-bars" aria-hidden="true"></i></button>
                </div>
<!-- TESTING BUTTON -->
    <!-- <a style="padding:10px;display:block;" href="" target="_blank">Click here for complete tutorial</a> -->

    <!-- Code begins here -->
    <!-- <div style="position:fixed; width:60px; height:60px; bottom:40px; right:40px; background-color:#0C9; color:#FFF;  border-radius:50px; text-align:center; box-shadow: 2px 2px 3px #999;">
        <a href="#" class="float">
        <i class="fa fa-plus my-float"><b><h2>+</h2></b></i>
        </a>
    </div> -->

<!-- TESTING BUTTON -->
                <!-- <button id="button1"class="btn btn-default toggle-sidebar-right">Click to toggle popover</button>                 -->
               
                <iframe src="http://localhost:5000/viewer?StudyInstanceUIDs=<?php echo $results->StudyInsta; ?>" style="width: 100%; height: 100%;"></iframe>

                    <!-- <h3><code>#content</code> <code class="width-6">.col-md-6</code> <code class="width-9">.col-md-9</code> <code class="width-12">.col-md-12</code></h3>
                    <div class="btn-group" role="group" aria-label="Controls">
                        <button type="button" class="btn btn-default toggle-sidebar-left">Toggle left</button>
                        <button type="button" class="btn btn-default toggle-sidebar-right">Toggle right</button>
                    </div>
                    <p>Changes between <code>.col-md-6</code>, <code>.col-md-9</code> and <code>.col-md-12</code> as sidebars are toggled, making use of the available space.</p>
                    <pre>#row-main {
  <span class="text-muted">/* necessary to hide collapsed sidebars */</span>
  overflow-x: hidden;
}

#content {
  <span class="text-muted">/* for the animation */</span>
  transition: width 0.3s ease;
}</pre>
                    <p>When toggling a sidebar switches the class <code>.collapsed</code> on the sidebar container and finds the number of open sidebars to determine the appropriate class to apply to the <code>#content</code> container.</p> -->
                </div>
                <div class="col-md-3 sidebar" id="sidebar-right">
                    <!-- <h3>
                        <p><code>#sidebar-right1</code></p>
                        <p><code>.col-md-3</code></p>
                    </h3>
                    <p>Has a negative right margin when collapsed.</p>
                    <pre>@media (min-width: 992px) {
  #sidebar-right.collapsed {
    <span class="text-muted">/* same width as sidebar */</span>
    margin-right: -25%;
  }
}</pre> -->


<div id="" style="overflow:scroll; height:100%;">
    @foreach($reports as $rep)
    <!-- <h3><b>{{$rep->created_at}}</b></h3> -->
    <h3><b>{{ \Carbon\Carbon::parse($rep->created_at)->format('M d Y g:i A') }}</b></h3>
    <!-- <h5><b>{{$rep->study_instance}}</b></h5><br> -->
     <h5>65464@@##</h5>
    {!! $rep->findings !!}
    <hr>
    @endforeach
</div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {

                function toggleSidebar(side) {
                    if (side !== "left" && side !== "right") {
                        return false;
                    }
                    var left = $("#sidebar-left"),
                        right = $("#sidebar-right"),
                        content = $("#content"),
                        openSidebarsCount = 0,
                        contentClass = "";

                    // toggle sidebar
                    // alert(left.hasClass("collapsed"));
                    if (side === "left") {
                        // left.toggleClass("collapsed");
                    } else if (side === "right") {
                        right.toggleClass("collapsed");
                    }

                    // determine number of open sidebars
                    if (!left.hasClass("collapsed")) {
                        // openSidebarsCount += 1;

                    }

                    if (!right.hasClass("collapsed")) {
                        openSidebarsCount += 1;
                    }

                    // determine appropriate content class
                    if (openSidebarsCount === 0) {
                        contentClass = "col-md-12";
                    } else if (openSidebarsCount === 1) {
                        contentClass = "col-md-9";
                    } else {
                        contentClass = "col-md-6";
                    }

                    // apply class to content
                    content.removeClass("col-md-12 col-md-9 col-md-6")
                        .addClass(contentClass);
                }
                $(".toggle-sidebar-left").click(function() {
                    // toggleSidebar("left");

                    return false;
                });
                $(".toggle-sidebar-right").click(function() {
                    toggleSidebar("right");

                    return false;
                });
            });
        </script>
    </body>

    </html>