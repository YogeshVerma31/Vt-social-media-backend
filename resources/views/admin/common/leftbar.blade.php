  <!-- ========== Left Sidebar Start ========== -->
  <div class="vertical-menu">

      <div data-simplebar class="h-100">

          <!-- User details -->
          <div class="user-profile text-center mt-3">

              <div class="mt-3">
                  <h4 class="font-size-16 mb-1">{{ Session::get('user')->name }}</h4>
                  <!-- <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i> Online</span> -->
              </div>
          </div>

          <!--- Sidemenu -->
          <div id="sidebar-menu">
              <!-- Left Menu Start -->
              <ul class="metismenu list-unstyled" id="side-menu">
                  <li class="menu-title">Menu</li>

                  @if (Session::get('user')->usertype == 1)
                      <li>
                          <a href="{{ route('dashboard') }}" class="waves-effect">
                              <i class="ri-dashboard-line"></i><span
                                  class="badge rounded-pill bg-success float-end">3</span>
                              <span>Dashboard</span>
                          </a>
                      </li>

                      <li>
                          <a href="javascript: void(0);" class="has-arrow waves-effect">
                              <i class="ri-dashboard-line"></i>
                              <span>UserType</span>
                          </a>
                          <ul class="sub-menu">
                              <li><a href="{{ route('view-create-usertype') }}">Create UserType</a></li>
                              <li><a href="{{ route('view-usertype') }}">View UserType</a></li>
                          </ul>
                      </li>

                      <li>
                          <a href="javascript: void(0);" class="has-arrow waves-effect">
                              <i class="ri-dashboard-line"></i>
                              <span>Course</span>
                          </a>
                          <ul class="sub-menu">
                              <li><a href="{{ route('view-create-course') }}">Create Course</a></li>
                              <li><a href="{{ route('view-course') }}">View Course</a></li>
                          </ul>
                      </li>

                      <li>
                          <a href="javascript: void(0);" class="has-arrow waves-effect">
                              <i class="ri-dashboard-line"></i>
                              <span>Subject</span>
                          </a>
                          <ul class="sub-menu">
                              <li><a href="{{ route('view-create-subject') }}">Create Subject</a></li>
                              <li><a href="{{ route('view-subject') }}">View Subject</a></li>
                          </ul>
                      </li>

                      <li>
                          <a href="javascript: void(0);" class="has-arrow waves-effect">
                              <i class="ri-dashboard-line"></i>
                              <span>Chapter</span>
                          </a>
                          <ul class="sub-menu">
                              <li><a href="{{ route('view-create-chapter') }}">Create Chapter</a></li>
                              <li><a href="{{ route('view-chapter') }}">View Chapter</a></li>
                          </ul>
                      </li>

                      <li>
                          <a href="javascript: void(0);" class="has-arrow waves-effect">
                              <i class="ri-dashboard-line"></i>
                              <span>User</span>
                          </a>
                          <ul class="sub-menu">
                              <li><a href="{{ route('view-create-user') }}">Create User</a></li>
                              <li><a href="{{ route('view-user') }}">View User</a></li>
                          </ul>
                      </li>
                      <li>
                          <a href="javascript: void(0);" class="has-arrow waves-effect">
                              <i class="ri-dashboard-line"></i>
                              <span>Today's learning video</span>
                          </a>
                          <ul class="sub-menu">
                              <li><a href="{{ route('create-today-learning') }}">Create trending video</a></li>
                              <li><a href="{{ route('view-today-learning') }}">View trending video</a></li>
                          </ul>
                      </li>
                  @endif

                  <li>
                      <a href="javascript: void(0);" class="has-arrow waves-effect">
                          <i class="ri-dashboard-line"></i>
                          <span>Video</span>
                      </a>
                      <ul class="sub-menu">
                          <li><a href="{{ route('view-create-video') }}">Create Video</a></li>
                          <li><a href="{{ route('view-video') }}">View Video</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="javascript: void(0);" class="has-arrow waves-effect">
                          <i class="ri-dashboard-line"></i>
                          <span>Subscription</span>
                      </a>
                      <ul class="sub-menu">
                          <li><a href="{{ route('view-create-subscription') }}">Create Subscription</a></li>
                          <li><a href="{{ route('view-subscription') }}">View Subscription</a></li>
                      </ul>
                  </li>


                  <li>
                      <a href="javascript: void(0);" class="has-arrow waves-effect">
                          <i class="ri-dashboard-line"></i>
                          <span>Coupon</span>
                      </a>
                      <ul class="sub-menu">
                          <li><a href="{{ route('view-create-coupon') }}">Create Coupon</a></li>
                          <li><a href="{{ route('view-coupon') }}">View Coupon</a></li>
                      </ul>
                  </li>



              </ul>
          </div>
          <!-- Sidebar -->
      </div>
  </div>
  <!-- Left Sidebar End -->
