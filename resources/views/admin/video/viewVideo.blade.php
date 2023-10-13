<!doctype html>
<html lang="en">

@include('admin.header');

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
                                <h4 class="mb-sm-0">View Video</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>

                                                <th>id</th>
                                                <th>Video Name</th>
                                                <th>Video Description</th>
                                                <th>Video Url</th>
                                                <th>Video Length</th>
                                                <th>Video Uploaded By</th>
                                                <th>Video Thumbnail</th>
                                                <th>Video Course</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Edit</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($videos as $videos)

                                            <tr>
                                                <td> {{ $videos->id }} </td>
                                                <td> {{ $videos->video_name}} </td>
                                                <td> {{ $videos->video_desc}} </td>
                                                <td> <a target="_" href="{{asset(Storage::url($videos->video_url))}}"> Link </a></td>
                                                <td> {{ $videos->video_length}} </td>
                                                <td> {{ $videos->users_name}} </td>
                                                <td class="text-center"> <img src="{{ Storage::url( $videos->video_thumbnail) }}" height="50" /> </td>

                                                <td> {{ $videos->category_name}} </td>

                                                <td> {{ $videos->created_at->format('d/m/Y ')}} </td>
                                                <td> {{ $videos->updated_at->format('d/m/Y ')}} </td>
                                                <td style="min-width: 50%;">
                                                    <div class="row">
                                                        <a href="{{ route('editVideo',$videos->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                        <a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
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

    @include('admin.utils.notification')
</body>

</html>
