<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Upcube - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

    <!-- jquery.vectormap css -->
    <link href="{{asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

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
                                <h4 class="mb-sm-0">Create Video</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Create Video</h4>
                                    <form class="needs-validation" method="POST" enctype="multipart/form-data" action="{{ route('createVideo') }}">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Video name</label>
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="Video name" name="video_name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Video description</label>
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="Video description" name="video_desc" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Video Url</label>
                                                    <input type="file" accept="video/*" class="form-control" id="validationCustom01" placeholder="Video Url" name="video_url" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Video Length</label>
                                                    <input type="text" class="form-control" id="validationCustom01" placeholder="Video Length(in seconds)" name="video_length" required>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="validationCustom01" class="form-label">Video Thumbnail</label>
                                                    <input type="file" accept="image/*" class="form-control" id="validationCustom01" placeholder="Video Thumbnail" name="video_thumbnail" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label>Select Course</label>
                                                    <select class="form-select" id="video_course" name="video_course" required="true" aria-label="Default select example">
                                                    <option value="">Select Course</option>
                                                     @foreach ($subject as $category)
                                                        <option value="{{ $category->category_id }}"> {{ $category->category_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label>Select Subject</label>
                                                    <select class="form-select" id="video_subject" name="video_subject" required="true" aria-label="Default select example">
                                                    <option value="">Select Subject</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label>Select Chapter</label>
                                                    <select class="form-select" id="video_chapter" name="video_chapter" required="true" aria-label="Default select example">
                                                    <option value="">Select Chapter</option>

                                                    </select>
                                                </div>
                                            </div>

                                        </div>


                                        <!--  -->
                                        <div class="col-md-6">
                                            <button class="btn btn-primary" type="submit">Create</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- end card -->
                        </div> <!-- end col -->

                    </div>
                    <!-- end row -->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->



        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('admin.common.rightbar')
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>


    <!-- apexcharts -->
    <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js')}}"></script>

    <!-- Required datatable js -->
    <script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Responsive examples -->
    <script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

    <script src="{{asset('assets/js/pages/dashboard.init.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="assets/js/pages/datatables.init.js"></script>

    <script>
        $('#video_course').on('change', e => {
            $('#video_subject').empty()
            $('#video_chapter').empty()

            $.ajax({
                url: `/getSubcategory/${e.target.value}`,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: data => {
                    $('#video_subject').append(`<option value="">Select Subject</option>`)
                    data.data.forEach(subcategory =>
                    $('#video_subject').append(`<option value="${subcategory.id}">${subcategory.subcategory_name}</option>`)
                )
                }
            })
        })

        $('#video_subject').on('change', e => {
            $('#video_chapter').empty()
            $.ajax({
                url: `/getChapter/${e.target.value}`,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: data => {
                    $('#video_chapter').append(`<option value="">Select Chapter</option>`)

                    data.data.forEach(subcategory =>
                    $('#video_chapter').append(`<option value="${subcategory.id}">${subcategory.name}</option>`)
                )
                }
            })
        })
    </script>

    @include('admin.utils.notification')
</body>

</html>
