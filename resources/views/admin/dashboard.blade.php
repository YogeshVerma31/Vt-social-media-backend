<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Upcube - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- jquery.vectormap css -->
    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



</head>

<body data-topbar="dark">



    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        @include('admin.common.header')
        @include('admin.common.leftbar')


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">


            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Dashboard</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VT Social Media</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">

                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Total Teacher</p>
                                            <h4 class="mb-2">{{count($teacher)}}</h4>
                                            <!-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p> -->
                                        </div>
                                        <!-- <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-primary rounded-3">
                                                <i class="ri-shopping-cart-2-line font-size-24"></i>
                                            </span>
                                        </div> -->
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Total Student</p>
                                            <h4 class="mb-2">938</h4>
                                            <!-- <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p> -->
                                        </div>
                                        <!-- <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-success rounded-3">
                                                <i class="mdi mdi-currency-usd font-size-24"></i>
                                            </span>
                                        </div> -->
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Total Course</p>
                                            <h4 class="mb-2">{{count($course)}}</h4>
                                            <!-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>16.2%</span>from previous period</p> -->
                                        </div>
                                        <!-- <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-primary rounded-3">
                                                <i class="ri-user-3-line font-size-24"></i>
                                            </span>
                                        </div> -->
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Total Subject</p>
                                            <h4 class="mb-2">{{count($subject)}}</h4>
                                            <!-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>11.7%</span>from previous period</p> -->
                                        </div>
                                        <!-- <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-success rounded-3">
                                                <i class="mdi mdi-currency-btc font-size-24"></i>
                                            </span>
                                        </div> -->
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Total Chapters</p>
                                            <h4 class="mb-2">{{count($chapter)}}</h4>
                                            <!-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>11.7%</span>from previous period</p> -->
                                        </div>
                                        <!-- <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-success rounded-3">
                                                <i class="mdi mdi-currency-btc font-size-24"></i>
                                            </span>
                                        </div> -->
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-truncate font-size-14 mb-2">Total Videos</p>
                                            <h4 class="mb-2">{{count($video)}}</h4>
                                            <!-- <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>11.7%</span>from previous period</p> -->
                                        </div>
                                        <!-- <div class="avatar-sm">
                                            <span class="avatar-title bg-light text-success rounded-3">
                                                <i class="mdi mdi-currency-btc font-size-24"></i>
                                            </span>
                                        </div> -->
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div>
                    </div><!-- end row -->


                    <!-- end row -->

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>

                                    <h4 class="card-title mb-4">Latest Transactions</h4>

                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Status</th>
                                                    <th>Age</th>
                                                    <th>Start date</th>
                                                    <th style="width: 120px;">Salary</th>
                                                </tr>
                                            </thead><!-- end thead -->
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h6 class="mb-0">Charles Casey</h6>
                                                    </td>
                                                    <td>Web Developer</td>
                                                    <td>
                                                        <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-success align-middle me-2"></i>Active</div>
                                                    </td>
                                                    <td>
                                                        23
                                                    </td>
                                                    <td>
                                                        04 Apr, 2021
                                                    </td>
                                                    <td>$42,450</td>
                                                </tr>
                                                <!-- end -->
                                                <tr>
                                                    <td>
                                                        <h6 class="mb-0">Alex Adams</h6>
                                                    </td>
                                                    <td>Python Developer</td>
                                                    <td>
                                                        <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-warning align-middle me-2"></i>Deactive</div>
                                                    </td>
                                                    <td>
                                                        28
                                                    </td>
                                                    <td>
                                                        01 Aug, 2021
                                                    </td>
                                                    <td>$25,060</td>
                                                </tr>
                                                <!-- end -->
                                                <tr>
                                                    <td>
                                                        <h6 class="mb-0">Prezy Kelsey</h6>
                                                    </td>
                                                    <td>Senior Javascript Developer</td>
                                                    <td>
                                                        <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-success align-middle me-2"></i>Active</div>
                                                    </td>
                                                    <td>
                                                        35
                                                    </td>
                                                    <td>
                                                        15 Jun, 2021
                                                    </td>
                                                    <td>$59,350</td>
                                                </tr>
                                                <!-- end -->
                                                <tr>
                                                    <td>
                                                        <h6 class="mb-0">Ruhi Fancher</h6>
                                                    </td>
                                                    <td>React Developer</td>
                                                    <td>
                                                        <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-success align-middle me-2"></i>Active</div>
                                                    </td>
                                                    <td>
                                                        25
                                                    </td>
                                                    <td>
                                                        01 March, 2021
                                                    </td>
                                                    <td>$23,700</td>
                                                </tr>
                                                <!-- end -->
                                                <tr>
                                                    <td>
                                                        <h6 class="mb-0">Juliet Pineda</h6>
                                                    </td>
                                                    <td>Senior Web Designer</td>
                                                    <td>
                                                        <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-success align-middle me-2"></i>Active</div>
                                                    </td>
                                                    <td>
                                                        38
                                                    </td>
                                                    <td>
                                                        01 Jan, 2021
                                                    </td>
                                                    <td>$69,185</td>
                                                </tr>
                                                <!-- end -->
                                                <tr>
                                                    <td>
                                                        <h6 class="mb-0">Den Simpson</h6>
                                                    </td>
                                                    <td>Web Designer</td>
                                                    <td>
                                                        <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-warning align-middle me-2"></i>Deactive</div>
                                                    </td>
                                                    <td>
                                                        21
                                                    </td>
                                                    <td>
                                                        01 Sep, 2021
                                                    </td>
                                                    <td>$37,845</td>
                                                </tr>
                                                <!-- end -->
                                                <tr>
                                                    <td>
                                                        <h6 class="mb-0">Mahek Torres</h6>
                                                    </td>
                                                    <td>Senior Laravel Developer</td>
                                                    <td>
                                                        <div class="font-size-13"><i class="ri-checkbox-blank-circle-fill font-size-10 text-success align-middle me-2"></i>Active</div>
                                                    </td>
                                                    <td>
                                                        32
                                                    </td>
                                                    <td>
                                                        20 May, 2021
                                                    </td>
                                                    <td>$55,100</td>
                                                </tr>
                                                <!-- end -->
                                            </tbody><!-- end tbody -->
                                        </table> <!-- end table -->
                                    </div>
                                </div><!-- end card -->
                            </div><!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-end">
                                        <select class="form-select shadow-none form-select-sm">
                                            <option selected>Apr</option>
                                            <option value="1">Mar</option>
                                            <option value="2">Feb</option>
                                            <option value="3">Jan</option>
                                        </select>
                                    </div>
                                    <h4 class="card-title mb-4">Monthly Earnings</h4>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="text-center mt-4">
                                                <h5>3475</h5>
                                                <p class="mb-2 text-truncate">Market Place</p>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-4">
                                            <div class="text-center mt-4">
                                                <h5>458</h5>
                                                <p class="mb-2 text-truncate">Last Week</p>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-4">
                                            <div class="text-center mt-4">
                                                <h5>9062</h5>
                                                <p class="mb-2 text-truncate">Last Month</p>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <div class="mt-4">
                                        <div id="donut-chart" class="apex-charts"></div>
                                    </div>
                                </div>
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->
                </div>

            </div>
            <!-- End Page-content -->

            <!-- <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Upcube.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign
                                </div>
                            </div>
                        </div>
                    </div>
                </footer> -->

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @include('admin.common.rightbar')

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>


    <!-- apexcharts -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- jquery.vectormap map -->
    <script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <script src="assets/js/pages/dashboard.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @include('admin.utils.notification')
</body>

</html>
