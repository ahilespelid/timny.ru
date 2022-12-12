@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add Mentor Category</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.mentor.category.list')}}"> Mentor Category List</a>
                      </li>
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
                      <div class="col-lg-6">
                        <form action="{{route('admin.mentor.category.store')}}" enctype="multipart/form-data" method="post">
                            @csrf
                      <div class="form-group mt-3">
                        <label>Parent Category</label>
                        <select class="form-control parent_category"  name="parent_id" >
                            <option class="form-control " value="0">Select Parent Category</option>

                            @foreach ($parent_category as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>

                                @foreach($category->subCategories as $option)
                                    <option value="{{$option->id}}">--{{$option->name}}</option>
                                    @foreach($option->subCategories as $option_sub)

                                        @if (count($option_sub->subCategories)>0)
                                            @foreach($option->subCategories as $option_sub)
                                            <option value="{{$option_sub->id}}">------{{$option_sub->name}}</option>
                                            @endforeach
                                        @else
                                        <option value="{{$option_sub->id}}">----{{$option_sub->name}}</option>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" required name="name" placeholder="Enter Category Name">
                      </div>
                      <div class="form-group">
                        <label>Category Image</label>
                        <input type="file" class="form-control " name="image" placeholder="International Phone Number">
                      </div>
                      <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control rounded-0" name="description" placeholder="Enter Description" id="" rows="10"></textarea>
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
@section('footerscript')
        <script>
            $(document).ready(function() {
                $(".parent_category").select2();
            });
        </script>
@endsection
