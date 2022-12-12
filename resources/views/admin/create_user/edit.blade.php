@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit User</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.listUser')}}"> User List</a>
                      </li>
                      <!-- <li class="breadcrumb-item active" aria-current="page">
                        Add New
                      </li> -->
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
                        <form action="{{route('admin.updateUser')}}"  method="post">
                            @csrf
                     <input type="hidden" name="id" value="{{$user->id}}" />
                     <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" value="{{$user->first_name}}" required name="first_name" placeholder="Enter First Name">
                      </div>
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" value="{{$user->last_name}}"  required name="last_name" placeholder="Enter Last Name">
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{$user->email}}"   required name="email" placeholder="Enter Email">
                      </div>
                      <div class="form-group">
                        <label>Password</label>
                        <input type="text" class="form-control" value="{{$user->password}}"   required name="password" placeholder="Enter Password">
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
