@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add Mentor Category</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.mentee.list')}}"> Mentee List</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Edit Mentee
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
                        <form action="{{route('admin.mentee.update')}}" enctype="multipart/form-data" method="post">
                            @csrf

                      <input type="hidden" name="id" value="{{$detail->id}}">
                      <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" required name="first_name"  value="{{$detail->user->first_name}}" placeholder="Enter First Name">
                              </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" required name="last_name" value="{{$detail->user->last_name}}" placeholder="Enter Last Name">
                              </div>
                          </div>

                          <div class="col-lg-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" required name="email"  value="{{$detail->user->email}}" placeholder="Enter Email">
                              </div>
                            </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" required name="phone" value="{{$detail->user->phone}}" placeholder="Enter Phone">
                              </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" class="form-control" required name="country"  value="{{$detail->user->country}}" placeholder="Enter Country">
                              </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" required name="city" value="{{$detail->user->city}}" placeholder="Enter City">
                              </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" required name="address"  value="{{$detail->user->address}}" placeholder="Enter Address">
                              </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label>Postal Code</label>
                                <input type="number" class="form-control" required name="postal_code" value="{{$detail->user->postal_code}}" placeholder="Enter Postal Code">
                              </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label>Profile Image</label> <br>
                                @if ($detail->user->image_path)
                                    <img src="{{asset($detail->user->image_path)}}" height="200" width="200" alt=""><br><br>
                                @endif
                                <input type="file" class="form-control " name="image">
                              </div>
                          </div>
                      </div>

                      <button class="btn btn-primary" type="submit">Update</button>

                    </form>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
@endsection
