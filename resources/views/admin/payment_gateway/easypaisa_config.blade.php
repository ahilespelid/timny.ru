@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add Payment </h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                       <a href=""> EasyPaisa Payment</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Add New/UpDate
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
                      <div class="col-lg-6">
                        <form action="{{route('admin.easypaisa_payment_gateway.store')}}"  method="post">
                            @csrf
                      <div class="form-group">
                        <label>Store ID#</label>
                        <input type="text" class="form-control" @isset($detail[0]->storeId)
                        value="{{$detail[0]->storeId}}"
                        @endisset required name="storeId" placeholder="Enter Store ID">
                      </div>
                      <div class="form-group">
                        <label>Hash</label>
                        <input type="text" class="form-control" @isset($detail[0]->hash)
                        value="{{$detail[0]->hash}}"
                        @endisset required name="hash" placeholder="Enter Hash">
                      </div>

                      @if (isset($detail[0]))
                      <button class="btn btn-primary" type="submit">Update</button>
                          @else
                          <button class="btn btn-primary" type="submit">Submit</button>
                      @endif

                    </form>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
@endsection
