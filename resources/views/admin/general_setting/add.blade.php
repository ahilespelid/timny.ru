@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add General Settings</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      {{-- <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.permission.list')}}"> Permission List</a>
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


                       
                      <div class="col-lg-6">
                        <form action="{{route('admin.general.store')}}" enctype="multipart/form-data" method="post">
                            @csrf
                            @if ($general)
                            <input type="hidden" value="{{$general->id}}" name="id" />
                            @endif

                      <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control"  required name="title"

                        value="{{isset($general->title)?$general->title:''}}"
                        placeholder="Enter Title">
                      </div>
                      <div class="form-group">
                        <label>TagLine</label>
                        <input type="text" class="form-control"  required name="tagline"

                        value="{{isset($general->tagline)?$general->tagline:''}}"
                        placeholder="Enter Tagline">
                      </div>
                      <div class="form-group">
                        <label>Seo Description</label>
                        <input type="text" class="form-control"  required name="seo_Des"

                        value="{{isset($general->seo_Des)?$general->seo_Des:''}}"
                        placeholder="Enter Seo Description">
                      </div>
                      <div class="form-group">
                        <label>Seo KeyWords</label>
                        <input type="text" class="form-control"  required name="seo_keywords"

                        value="{{isset($general->seo_keywords)?$general->seo_keywords:''}}"
                        placeholder="Enter Seo KeyWords">
                      </div>
                      <div class="form-group">
                        <label>Facebook Link</label>
                        <input type="text" class="form-control"  required name="facebook_link"

                        value="{{isset($general->facebook_link)?$general->facebook_link:''}}"
                        placeholder="Enter Facebook Link">
                      </div>
                      <div class="form-group">
                        <label>Twitter Link</label>
                        <input type="text" class="form-control"  required name="twitter_link"

                        value="{{isset($general->twitter_link)?$general->twitter_link:''}}"
                        placeholder="Enter Twitter Link">
                      </div>
                      <div class="form-group">
                        <label>LinkDen Link</label>
                        <input type="text" class="form-control"  required name="linkden_link"

                        value="{{isset($general->linkden_link)?$general->linkden_link:''}}"
                        placeholder="Enter LinkDen Link">
                      </div>
                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control"  required name="address"

                        value="{{isset($general->address)?$general->address:''}}"
                        placeholder="Enter Address">
                      </div>
                      <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control"  required name="phone"

                        value="{{isset($general->phone)?$general->phone:''}}"
                        placeholder="Enter Phone">
                      </div>
                      <div class="form-group">
                        <label>Company Email</label>
                        <input type="text" class="form-control"  required name="company_email"

                        value="{{isset($general->company_email)?$general->company_email:''}}"
                        placeholder="Enter Company Email">
                      </div>
                      <div class="form-group">
                        <label>About Company</label>
                        <input type="text" class="form-control"  required name="about_company"

                        value="{{isset($general->about_company)?$general->about_company:''}}"
                        placeholder="Enter About Company">
                      </div>
                      <div class="form-group">
                        <label>Site Logo</label>
                        <input type="file" class="form-control"   name="logo">
                      </div>

                     @if(isset($general->logo))
                     <img src="{{asset($general->logo)}}" width="150px" height="150px" />
                     @endif
                      <button class="btn btn-primary" type="submit">

                        @if ($general)
                        Update
                        @else
                        Submit
                        @endif
                    </button>

                    </form>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
@endsection
