@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add Blog Category</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.blog.category.list')}}"> Blog Category List</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Edit Blog Category
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
                        <form action="{{route('admin.blog.category.update')}}" enctype="multipart/form-data" method="post">
                            @csrf
                      <input type="hidden" name="id" value="{{$detail->id}}">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" required name="name" value="{{$detail->name}}" placeholder="Enter Category Name">
                      </div>
                      <div class="form-group">
                        <label>Category Image</label> <br>
                        @if ($detail->image_path)
                            <img src="{{asset($detail->image_path)}}" height="200" width="200" alt=""><br><br>
                        @endif
                        <input type="file" class="form-control " name="image" placeholder="International Phone Number">
                      </div>
                      <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control rounded-0" name="description" id="" cols="30" rows="10">{{$detail->description}}</textarea>
                      </div>
                      <button class="btn btn-primary" type="submit">Update</button>

                    </form>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
@endsection
