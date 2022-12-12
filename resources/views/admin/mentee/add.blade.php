@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add Mentee</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.mentee.list')}}"> Mentee List</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Add New
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


          <div class="row">
              <div class="col-lg-12 mt-3">
                <div class="card">
                    <div class="card-body">
                      <div class="col-lg-12">
                        <form action="{{route('admin.mentee.store')}}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>First Name</label>
                                      <input type="text" class="form-control" name="first_name"  placeholder="Enter First Name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Last Name</label>
                                      <input type="text" class="form-control" name="last_name"  placeholder="Enter Last Name">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Email</label>
                                      <input type="email" class="form-control" name="email" placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Phone</label>
                                      <input type="text" class="form-control" required name="phone"  placeholder="Enter Phone">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Country</label>
                                      <input type="text" class="form-control" name="country"  placeholder="Enter Country">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>City</label>
                                      <input type="text" class="form-control" name="city"  placeholder="Enter City">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Address</label>
                                      <input type="text" class="form-control" name="address"   placeholder="Enter Address">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Postal Code</label>
                                      <input type="number" class="form-control" name="postal_code"  placeholder="Enter Postal Code">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Profile Image</label> <br>
                                      <input type="file" class="form-control " name="image">
                                    </div>
                                </div>
                            </div>

                      <button class="btn btn-primary" type="submit">Submit</button>

                    </form>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
@endsection
