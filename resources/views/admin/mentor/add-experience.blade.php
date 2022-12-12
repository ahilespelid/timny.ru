@extends('admin.layouts.app')

@section('content')
    <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add Mentor Experience</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      {{-- <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.mentor.category.list')}}"> Mentor List</a>
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
                      <h2>Mentor Experience</h2>
                    <div class="col-lg-12">
                        <form action="{{route('admin.mentor.save.experience')}}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Mentor</label>
                                      <select class="form-control mentor"  name="mentor_id" id="mentor_id" required>
                                        <option> Select Mentor</option>
                                        @foreach ($mentors as $mentor)

                                        <option value="{{$mentor->user_id}}"> {{!empty($mentor->user->first_name)?$mentor->user->first_name:""}} {{!empty($mentor->user->last_name)?$mentor->user->last_name:""}}</option>
                                        @endforeach
                                       </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Company</label>
                                        <input required type="text" class="form-control" required name="company"  placeholder="Enter company">
                                      </div>
                                  </div>
                                  <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>From</label>
                                        <input  type="date" class="form-control"  name="from"  placeholder="Enter from">
                                      </div>
                                  </div>
                                  <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>To</label>
                                        <input  type="date" class="form-control"  name="to"  placeholder="Enter to">
                                      </div>
                                  </div>

                                  <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Experience Image</label>
                                        <input  type="file" class="form-control"  name="image" >
                                      </div>
                                  </div>
                                  <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                  </div>
              </div>
            </div>
          </div>

@endsection
@section('footerscript')
        <script>
            $(document).ready(function() {
                $(".mentor").select2();
            });
        </script>
@endsection
