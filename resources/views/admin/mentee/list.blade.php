@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Mentee List</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Mentee List
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
                            <a href="{{route('admin.mentee.add')}}" class="btn btn-primary mb-4 float-end">Add New</a>
                        </div>
                        <div class="clearfix"></div>
                    <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">SR. #</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody class="customtable">
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($mentees as $mentee)
                                <tr>
                                    <th>{{$count}}</th>
                                    {{-- @isset($mentee->user->first_name ) --}}
                                        <td>{{!empty($mentee->user->first_name)?$mentee->user->first_name . ' ' . $mentee->user->last_name:'' }}</td>
                                    {{-- @endisset --}}
                                    {{-- @isset($mentee->user->email) --}}
                                        <td>{{!empty($mentee->user->email)?$mentee->user->email:''}}</td>
                                    {{-- @endisset --}}
                                    {{-- @isset($mentee->user->phone) --}}
                                        <td>{{!empty($mentee->user->phone)?$mentee->user->phone:''}}</td>
                                    {{-- @endisset --}}
                                    {{-- @isset($mentee->user->image_path) --}}
                                        <td>
                                            @if (isset($mentee->user->image_path) && !empty($mentee->user->image_path))
                                            <img src="{{asset($mentee->user->image_path)}}" height="50" width="50" alt="">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    {{-- @endisset --}}
                                    <td>
                                        <a href="{{ route('admin.mentee.detail', $mentee->id) }}"><i class="mdi mdi-table-edit"></i></a>
                                        <a onclick="deleteRow('{{route('admin.mentee.delete',['id'=>$mentee->id])}}')"><i class="me-2 mdi mdi-delete"></i></a>
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
