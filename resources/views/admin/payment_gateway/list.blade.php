@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Payment Method List</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Payment Method List
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
                            <a href="{{route('admin.payment_gateway.add')}}" class="btn btn-primary mb-4 float-end">Add New</a>
                        </div>
                        <div class="clearfix"></div>
                    <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">SR. #</th>
                            <th scope="col">Name</th>
                            <th scope="col">Code</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody class="customtable">
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($paymentMethods as $paymentMethod)
                                <tr>
                                    <th>{{$count}}</th>
                                    {{-- @isset($mentee->user->first_name ) --}}
                                        <td>

                                            {{$paymentMethod->name }}


                                        </td>
                                    {{-- @endisset --}}
                                    {{-- @isset($mentee->user->email) --}}
                                        <td>{{$paymentMethod->code}}</td>
                                    {{-- @endisset --}}
                                    {{-- @isset($mentee->user->phone) --}}
                                        <td>{{$paymentMethod->description}}</td>
                                    {{-- @endisset --}}
                                    {{-- @isset($mentee->user->image_path) --}}
                                        <td>
                                            @if (isset($paymentMethod->image_id) && !empty($paymentMethod->image_id))
                                            <img src="{{asset($paymentMethod->image_id)}}" height="50" width="50" alt="">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    {{-- @endisset --}}
                                    <td>
                                        <a href="{{ route('admin.payment_gateway.edit', $paymentMethod->id) }}"><i class="mdi mdi-table-edit"></i></a>
                                        <a onclick="deleteRow('{{route('admin.payment_gateway.delete',['id'=>$paymentMethod->id])}}')"><i class="me-2 mdi mdi-delete"></i></a>
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


<script>
    function deleteRow(url){
        var result = confirm("Are you sure you want to delete it?");
        if (result==true) {
        window.location.href=url;
        } else {
        return false;
        }
    }
</script>
@section('footerscript')
<script>

    $('.table').DataTable();
</script>
@endsection
