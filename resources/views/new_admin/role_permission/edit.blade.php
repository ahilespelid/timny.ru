@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Role Permission </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="">Home</a></li>
            <li class="breadcrumb-item active"> <a href="{{route('admin.rolepermission.list')}}"> Role Permission List</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->


  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-secondary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Role Permission</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('admin.rolepermission.update')}}"  method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$rolepermission->id}}"/>
                    <div class="card-body">

                          <div class="form-group">
                            <label>Roles</label>
                        <select class="form-control " name="role" >
                            <option class="form-control " value="0">Select Role</option>
                            @foreach($roles as $role)
                            <option class="form-control"

                            @if($rolepermission->role_id==$role->id)
                            {{"selected"}}
                            @endif
                            value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>

                    </div>
                    
                 <h1>Select Permission</h1>
                            <div class="form-check">
                                <input type="checkbox" id="check-all"  class="form-check-input" />
                                <label class="form-check-label"><h3>Select All</h3></label>
                            </div>
                            @foreach($permissions as $permission)
                            <div class="form-check form-check-inline">
                                <input type="checkbox"
                                @if($rolepermission->permission_id==$permission->id)
                        {{"checked"}}
                        @endif
                                name="permissions[]" class="form-check-input check-permission" value="{{$permission->id}}" />
                                <label class="form-check-label">{{$permission->name}}</label>
                            </div>
                            @endforeach


                    <!-- /.card-body -->

                    <div class="col-md-6 pl-0">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->



              </div>

      </div>
    </div>
  </section>
@endsection
