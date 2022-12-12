@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Contact Us List</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Contact Us List
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
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Message</th>
                            {{-- <th scope="col">Action</th> --}}
                        </tr>
                        </thead>
                        <tbody class="customtable">
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($contactuslist as $contactus)
                                <tr>
                                    <td>{{$count}}</td>
                                    {{-- @isset($mentee->user->first_name ) --}}
                                        <td>{{!empty($contactus->name)?$contactus->name:'' }}</td>
                                    {{-- @endisset --}}
                                    {{-- @isset($mentee->user->email) --}}
                                        <td>{{!empty($contactus->email)?$contactus->email:''}}</td>
                                    {{-- @endisset --}}
                                    {{-- @isset($mentee->user->phone) --}}
                                        <td>{{!empty($contactus->message)?$contactus->subject:''}}</td>
                                    {{-- @endisset --}}
                                    {{-- @isset($mentee->user->image_path) --}}

                                        <td>{{!empty($contactus->subject)?$contactus->message:''}}</td>

                                    {{-- @endisset --}}

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
