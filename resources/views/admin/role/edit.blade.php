@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit Role</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.role.list')}}"> Role List</a>
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
                        <form action="{{route('admin.role.update')}}"  method="post">
                            @csrf
                     <input type="hidden" name="id" value="{{$role->id}}" />
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{$role->name}}" required name="name" placeholder="Enter Role Name">
                      </div>
                      <div class="form-group">
                        <label>Slug</label>
                        <input type="text" class="form-control" value="{{$role->slug}}" required name="slug" placeholder="Enter Role Slug">
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
