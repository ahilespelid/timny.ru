@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add Mentor Details</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                       <a href="{{route('admin.mentor.category.list')}}"> Mentor List</a>
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
                        <h2>Personal Info</h2>
                      <div class="col-lg-12">
                        <form action="{{route('admin.mentor.store')}}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>First Name</label>
                                      <input type="text" class="form-control"  name="first_name"  placeholder="Enter First Name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Last Name</label>
                                      <input type="text" class="form-control"  name="last_name"  placeholder="Enter Last Name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Father Name</label>
                                        <input type="text" class="form-control"  name="father_name" placeholder="Enter Father Name">
                                      </div>
                                  </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Email</label>
                                      <input type="email" class="form-control"  name="email" placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>CNIC</label>
                                        <input type="text" class="form-control"  name="cnic" placeholder="Enter CNIC">
                                      </div>
                                  </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Phone</label>
                                      <input type="text" class="form-control"  name="phone"  placeholder="Enter Phone">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>DOB</label>
                                        <input type="date"  class="form-control"  id="birthday" name="dob">
                                      </div>
                                  </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select aria-label="Default select example" name="gender" class="form-select"><option value="" selected="selected">
                                            Select Gender
                                          </option> <option value="male">
                                            Male
                                          </option> <option value="female">
                                            Female
                                          </option> <option value="other">
                                            Other
                                          </option></select>
                                      </div>
                                  </div>
                                  <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Occupation</label>
                                        <select aria-label="Default select example" name="occupation" class="form-select"><option value="" selected="selected">
                                            Select Occupation
                                          </option>
                                          @foreach ($occupations as $occupation)
                                              <option value="{{$occupation->id}}">{{$occupation->name}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                  </div>

                                  <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Religion</label>
                                        <select aria-label="Default select example" name="religion"class="form-select"><option value="" selected="selected">
                                            Select Religion
                                          </option> <option value="islam">Islam</option> <option value="christian">Christian</option> <option value="hindu">Hindu</option> <option value="sikh">Sikh</option> <option value="jew">Jew</option> <option value="buddist">Buddhist</option> <option value="other">Others</option></select>
                                      </div>
                                  </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Country</label>
                                      <select class="form-control"  name="country" id="country">
                                        <option value=""> Select Country</option>
                                       @foreach ($countries as $country)

                                       <option value="{{$country->id}}"> {{$country->name}}</option>
                                       @endforeach
                                      </select>
                                  </div>
                          </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>City</label>
                                      <input type="text" class="form-control"  name="city"  placeholder="Enter City">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Address</label>
                                      <input type="text" class="form-control"  name="address"   placeholder="Enter Address">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Postal Code</label>
                                      <input type="number" class="form-control"  name="postal_code"  placeholder="Enter Postal Code">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                      <label>Profile Image</label> <br>
                                      <input type="file" class="form-control " name="image">
                                    </div>
                                </div>
                            </div>

                 <div class="row">
                        <div class="col-lg-6 mt-3">
                            <div class="card">
                            <div class="card-body">
                            <h2>SKills</h2>

                               <div class="form-group">
                                <label>Parent Category</label>
                                  <select class="form-control"  name="categories[]" id="parent_category">
                                     <option  value=""> Choose Parent Category</option>
                                        @foreach ($mentor_parent_categories as $parent_category)
                                         <option value="{{$parent_category->id}}" > {{$parent_category->name}}</option>
                                        @endforeach
                                 </select>
                            </div>

                            <div class="form-group">
                                <label>SubCategory</label>
                                 <select class="form-control" name="categories[]" id="sub_category">
                                    <option  value="">Choose SubCategory</option>
                                 </select>
                            </div>
                            <div class="form-group">
                                <label>SubCategory</label>
                                 <select class="form-control" name="categories[]" id="child_sub_category">
                                    <option  value="">Choose Child SubCategory</option>
                                 </select>
                            </div>

                            </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <div class="card">
                               <div class="card-body">
                                  <h2>Bank Account Details</h2>

                                     <div class="form-group">
                                     <label>Account Holder Name</label>
                                     <input type="text" class="form-control"  name="account_title" placeholder="Enter Account Title">
                                    </div>
                                      <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control"  name="account_number"  placeholder="Enter Account Number">
                                         </div>
                                        <div class="form-group">
                                        <label>Bank</label>
                                        <select name="bank" class="form-control" id="">
                                            <option value=""> Select Bank</option>
                                            @foreach ($banks as $bank)
                                            <option value="{{$bank->name}}">{{$bank->name}}</option>
                                            @endforeach
                                        </select>
                                  </div>

                         </div>
                         </div>
                        </div>
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


@push('scripts')
     <script>
             $(document).ready(function() {
            $('#parent_category').on('change', function() {
               var parent_category_id = $(this).val();
               var base_url = "<?php echo URL::to('/'); ?>";
               console.log(window.location.origin);
               if(parent_category_id) {
                   $.ajax({
                       url: base_url + '/api/mentorChildCategoriesList',
                       type: "GET",
                       data : {"token":"123",parent_id:parent_category_id},
                       dataType: "json",
                       success:function(data)
                       {
                        var sub_category_select=$('#sub_category');
                         if(data){

                            sub_category_select.empty();
                            sub_category_select.append('<option value="">Choose SubCategory</option>');
                            $.each(data.data.mentorCategories, function(key, sub_category){
                                sub_category_select.append('<option value="'+ sub_category.id +'">' + sub_category.name + '</option>');
                            });
                        }else{
                            sub_category.empty();
                        }
                     }
                   });
               }else{
                 $('#sub_category').empty();
               }
            });

            $('#sub_category').on('change', function() {
               var parent_category_id = $(this).val();
               var base_url = "<?php echo URL::to('/'); ?>";
               if(parent_category_id) {
                   $.ajax({
                       url: base_url + '/api/mentorChildCategoriesList',
                       type: "GET",
                       data : {"token":"123",parent_id:parent_category_id},
                       dataType: "json",
                       success:function(data)
                       {
                           var child_sub_category=$('#child_sub_category');
                         if(data){
                            child_sub_category.empty();
                            child_sub_category.append('<option value="">Choose Child SubCategory</option>');
                            $.each(data.data.mentorCategories, function(key, sub_category){
                                child_sub_category.append('<option value="'+ sub_category.id +'">' + sub_category.name + '</option>');
                            });
                        }else{
                            child_sub_category.empty();
                        }
                     }
                   });
               }else{
                 $('#sub_category').empty();
               }
            });
            });
        </script>
    @endpush

