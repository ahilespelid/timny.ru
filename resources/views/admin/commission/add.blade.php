@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add Commission</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      {{-- <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.permission.list')}}"> Permission List</a>
                      </li> --}}
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
                      <div class="col-lg-6">
                        <form action="{{route('admin.commission.store')}}"  method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$commission->id}}" />
                      <div class="form-group">
                        <label>Fix

                            <input
                            @isset($commission)
                            {{$commission->fixed==1?'Checked':''}}
                            @endisset

                            type="radio" class=" form-check" value="1" required name="fix" >

                        </label>
                        <br>
                        <label>Percentage
                            <input
                            @isset($commission)
                            {{$commission->fixed==0?'Checked':''}}
                            @endisset
                            type="radio" class="form-check" value="0" required name="fix" >

                        </label>


                    </div>
                      <div class="form-group">
                        <label>Amount</label>
                        <input type="text" class="form-control"  required name="amount"
                        @isset($commission)
                        value="{{$commission->amount}}"
                        @endisset
                        placeholder="Enter Amount">
                      </div>
                      <button class="btn btn-primary" type="submit">

                        @if ($commission)
                        Update
                        @else
                        Submit
                        @endif
                    </button>

                    </form>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
@endsection
