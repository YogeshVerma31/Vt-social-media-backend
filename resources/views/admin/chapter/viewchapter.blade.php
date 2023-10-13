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
                                <h4 class="mb-sm-0">View Chapter</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="needs-validation" method="GET" action="{{ route('view-chapter') }}">

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <select class="form-select" name="id" required="true" aria-label="Default select example">
                                                    @foreach ($subject as $category)
                                                    <option value="{{ $category->id }}"> {{ $category->subcategory_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            </div>
                                            <div class="col-sm-1">
                                            <a class="btn btn-primary" href="{{route('view-chapter')}}">Clear</a>
                                            </div>

                                        </div>

                                    </form>
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Subject Name</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($chapter as $category)
                                            <tr>
                                                <td> {{ $category->id }} </td>
                                                <td> {{ $category->name}} </td>
                                                <td class="text-center"> <img src="{{ Storage::disk('s3')->url( $category->image) }}" height="50" /> </td>
                                                <td> {{ $category->subcategory_name}} </td>
                                                <td> @if($category->status=='0')
                                                    <a href="{{ route('updateChapterStatus', ['id' => $category->id]) }}" class="btn-sm btn btn-danger waves-effect waves-light">inactive</a>
                                                    @else
                                                    <a href="{{ route('updateChapterStatus', ['id' => $category->id]) }}" class="btn-sm btn btn-success waves-effect waves-light">active</a>
                                                    @endif

                                                </td>
                                                <td> {{ $category->created_at->format('d/m/Y ')}} </td>
                                                <td> {{ $category->updated_at->format('d/m/Y ')}} </td>
                                                <td style="min-width: 50%;">
                                                    <div class="row">
                                                        <a href="{{ route('editChapter',$category->id) }}" class="btn btn-sm btn-warning mb-2"><i class="fa fa-edit"></i></a>
                                                        <!-- <a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a> -->
                                                    </div>
                                                </td>

                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
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

    @include('admin.utils.notification')
</body>

</html>
