@extends('admin.layouts.app')

@section('content')
<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Dashboard</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Dashboard
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>
          <!-- ============================================================== -->
          <!-- End Bread crumb and right sidebar toggle -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- Container fluid  -->
          <!-- ============================================================== -->
          <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Sales Cards  -->
            <!-- ============================================================== -->
            <div class="row">
              <!-- Column -->
              @permission('roles')
              <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                  <div class="box bg-cyan text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi mdi-view-dashboard"></i>
                    </h1>
                    <h6 class="text-white"><a class="text-white" href="{{route('admin.user.role.list')}}">Roles</a></h6>
                  </div>
                </div>
              </div>
              @endpermission
              @permission('permissions')
              <!-- Column -->
              <div class="col-md-6 col-lg-4 col-xlg-3">
                <div class="card card-hover">
                  <div class="box bg-success text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi mdi-chart-areaspline"></i>
                    </h1>
                    <h6 class="text-white"><a class="text-white" href="{{route('admin.permission.list')}}">Permissions</a></h6>
                  </div>
                </div>
              </div>
              @endpermission
              <!-- Column -->
              {{-- @permission('add-jazzcash')
              <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                  <div class="box bg-warning text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi mdi-credit-card"></i>
                    </h1>
                    <h6 class="text-white"><a class="text-white" href="{{route('admin.payment_gateway.add')}}">Configure JazzCash</a></h6>
                  </div>
                </div>
              </div>
              @endpermission
              @permission('add-easypaisa')
              <!-- Column -->
              <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                  <div class="box bg-danger text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi mdi-credit-card"></i>
                    </h1>
                    <h6 class="text-white"><a class="text-white" href="{{route('admin.easypaisa_payment_gateway.add')}}">Configure EasyPaisa</a></h6>
                  </div>
                </div>
              </div>
              @endpermission --}}
              <!-- Column -->
              @permission('mentee-list')
              <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                  <div class="box bg-info text-center">
                    <h1 class="font-light text-white">
                      <i class="mdi mdi-account"></i>
                    </h1>
                    <h6 class="text-white"><a class="text-white" href="{{route('admin.mentee.list')}}">User List</a></h6>
                  </div>
                </div>
              </div>
              @endpermission
              <!-- Column -->

            </div>
            <!-- ============================================================== -->
            <!-- Sales chart -->
            <!-- ============================================================== -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="d-md-flex align-items-center">
                      <div>
                        <h4 class="card-title">Site Analysis</h4>
                        <h5 class="card-subtitle">Latest Overview</h5>
                      </div>
                    </div>
                    <div class="row">
                      <!-- column -->

                      <div class="col-lg-12">
                        <div class="row">
                          <div class="col-6">
                            <div class="bg-dark p-10 text-white text-center">
                              <i class="mdi mdi-account fs-3 mb-1 font-16"></i>
                              <h5 class="mb-0 mt-1">{{$menteeCount}}</h5>
                              <small class="font-light">Total Users</small>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="bg-dark p-10 text-white text-center">
                              <i class="mdi mdi-account fs-3 font-16"></i>
                              <h5 class="mb-0 mt-1">{{$mentorCount}}</h5>
                              <small class="font-light">Total Consultant</small>
                            </div>
                          </div>
                          <div class="col-6 mt-3">
                            <div class="bg-dark p-10 text-white text-center">
                              <i class="mdi mdi-table fs-3 mb-1 font-16"></i>
                              <h5 class="mb-0 mt-1">{{$appointment_completed}}</h5>
                              <small class="font-light">Total Completed Appointments</small>
                            </div>
                          </div>
                          <div class="col-6 mt-3">
                            <div class="bg-dark p-10 text-white text-center">
                              <i class="mdi mdi-table fs-3 mb-1 font-16"></i>
                              <h5 class="mb-0 mt-1">{{$appointment_pending}}</h5>
                              <small class="font-light">Total Pending Appointments</small>
                            </div>
                          </div>
                          <div class="col-6 mt-3">
                            <div class="bg-dark p-10 text-white text-center">
                              <i class="mdi mdi-table fs-3 mb-1 font-16"></i>
                              <h5 class="mb-0 mt-1">{{$appointment_cancel}}</h5>
                              <small class="font-light">Total Cancel Appointments</small>
                            </div>
                          </div>
                          <div class="col-6 mt-3">
                            <div class="bg-dark p-10 text-white text-center">
                              <i class="mdi mdi-table fs-3 mb-1 font-16"></i>
                              <h5 class="mb-0 mt-1">{{$appointment_accepted}}</h5>
                              <small class="font-light">Total Accepted Appointments</small>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- column -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- ============================================================== -->
            <!-- Sales chart -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Recent comment and chats -->
            <!-- ============================================================== -->


          </div>

@endsection
