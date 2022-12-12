@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add Payment Method Settings</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.payment_settings.list')}}"> Payment Method Settings List</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Edit Payment Method Settings
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
                        <form action="{{route('admin.payment_settings.update')}}" enctype="multipart/form-data" method="post">
                            @csrf

                      <input type="hidden" name="id" value="{{$payment_setting->id}}">
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Payment Method</label>

                                <select name="payment_method_id" class="form-control">
                                    <option value="">Select Payment Method</option>
                                    @foreach ($payment_methods as $payment_method)
                                        <option {{$payment_method->id==$payment_setting->payment_method_id?'selected':''}} value="{{$payment_method->id}}">{{$payment_method->name}}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" class="form-control" name="name"  placeholder="Enter Field Name"> --}}
                              </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label>Field Name</label>
                                <input type="text" class="form-control" required name="name"  value="{{$payment_setting->name}}" placeholder="Enter  Field Name">
                              </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label>Field Value</label>
                                <input type="text" class="form-control" required name="value" value="{{$payment_setting->value}}" placeholder="Enter Field Value">
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
