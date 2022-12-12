@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add Payment Method</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.payment_gateway.list')}}"> Payment Method List</a>
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
                        <form action="{{route('admin.payment_gateway.store')}}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Payment Method</label>
                                      <input type="text" class="form-control" name="name"  placeholder="Enter Payment Method">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Code</label>
                                        <input type="text" class="form-control" name="code"  placeholder="Enter Code">
                                      </div>
                                  </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control" name="description"  placeholder="Enter Description">
                                      </div>
                                  </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Logo</label> <br>
                                      <input type="file" class="form-control " name="image_id">
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
