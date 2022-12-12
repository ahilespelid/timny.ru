@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">WithDraw Request List</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                        WithDraw Request List
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
                            {{-- <a href="{{route('admin.mentee.add')}}" class="btn btn-primary mb-4 float-end">Add New</a> --}}
                        </div>
                        <div class="clearfix"></div>
                    <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">SR. #</th>
                            <th>Created At</th>
                            <th scope="col">User</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>

                        </tr>
                        </thead>
                        <tbody class="customtable">
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($withRrawRequests as $withRrawRequest)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{date('Y-M-d',strtotime($withRrawRequest->created_at))}}</td>

                                    @isset($withRrawRequest->user->first_name )
                                        <td>{{$withRrawRequest->user->first_name }} {{$withRrawRequest->user->last_name }} </td>
                                    @endisset

                                        <td>{{$withRrawRequest->amount}}</td>

                                    {{-- @isset($mentee->user->phone) --}}
                                        <td>{{$withRrawRequest->status?"Paid":'Pending'}}</td>
                                    {{-- @endisset --}}
                                    <td>
                                        @php
                                            if($withRrawRequest->status){
                                                echo "<b>Already Paid</b>";
                                            }else {
                                                 echo "<a href='".route('admin.paid-withdraw', $withRrawRequest->id)."'>Pay it</a>";
                                            }
                                        @endphp

                                    </td>

                                </tr>
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
@endsection



@section('footerscript')
<script>

    $('.table').DataTable();
</script>
@endsection
