@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit Blog</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.blog.category.list')}}"> Blog List</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Edit Blog
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
                        <form action="{{route('admin.blog.update')}}" enctype="multipart/form-data" method="post">
                            @csrf
                      <input type="hidden" name="id" value="{{$detail->id}}">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control"  name="title" value="{{$detail->title}}" placeholder="Enter  Name">
                      </div>
                      <div class="form-group">
                        <label>Feature</label>
                        <select class="form-control"  name="featured" id="">
                            <option {{$detail->featured==0?"selected":''}}  value="0">No</option>
                            <option {{$detail->featured==1?"selected":''}}  value="1">Yes</option>
                        </select>
                    </div>
                      <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="category_id" name="category_id" >
                            <option selected value="">Select Category</option>
                            @foreach($categories as $category)
                            <option @if ($category->id == $detail->id)
                                selected
                            @endif value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
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
                        <textarea class="form-control rounded-0" id="" name="description" placeholder="Enter Description" rows="10">{{$detail->description}}</textarea>
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
