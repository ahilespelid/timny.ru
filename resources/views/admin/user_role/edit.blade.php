@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit User Role</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.user.role.list')}}">User Role List</a>
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
                        <form action="{{route('admin.user.role.update')}}"  method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$userrole->id}}"/>
                        <div class="form-group mt-3">
                        <label>Users</label>
                        <select class="form-control " name="user" >
                            <option class="form-control " value="0">Select User</option>
                            @foreach($users as $user)
                            <option class="form-control"
                            @if($userrole->user_id==$user->id)
                            {{"selected"}}
                            @endif
                            value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group mt-3">
                        <label>Roles</label>
                        <select class="form-control " name="role" >
                            <option class="form-control " value="0">Select Role</option>
                            @foreach($roles as $role)
                            <option class="form-control"

                            @if($userrole->role_id==$role->id)
                            {{"selected"}}
                            @endif
                            value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
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
