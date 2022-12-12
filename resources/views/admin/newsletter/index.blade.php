@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Mentor Newsletter List</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Mentor Newsletter List
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
                        {{-- <div class="col-lg-12">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#mentorOccupationModel" class="btn btn-primary mb-4 float-end">Add New</button>

                        <!-- Modal -->
                    <div class="modal fade" id="mentorOccupationModel" tabindex="-1" aria-labelledby="mentorOccupationModelLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="mentorOccupationModelLabel">Mentor List</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admin.mentor.occupation.store')}}"method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Occupation Name</label>
                                        <input type="text" class="form-control" required name="name"  placeholder="Enter Occupation Name">
                                      </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>

                        </div>
                        </div>
                    </div>
                        </div> --}}
                        <div class="clearfix"></div>
                    <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">SR. #</th>
                            <th scope="col">Email</th>
                        </tr>
                        </thead>
                        <tbody class="customtable">
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($newsletters as $newsletter)
                                <tr>
                                    <th>{{$count}}</th>
                                    <td>{{$newsletter->email}}</td>
                                    {{-- <td> --}}

                                        {{-- <span  data-bs-toggle="modal" data-bs-target="#mentorOccupationEditModel_{{ $occupation->id }}" ><i class="mdi mdi-table-edit" data-id="{{ $occupation->id }}"></i></span> --}}

                                        <!-- Modal -->
                                        {{-- <div class="modal fade" id="mentorOccupationEditModel_{{ $occupation->id }}" tabindex="-1" aria-labelledby="mentorOccupationEditModelLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="mentorOccupationEditModelLabel">Edit Occupation Model</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('admin.mentor.occupation.update')}}"  method="post">
                                                        @csrf

                                                  <input type="hidden" name="id"  value="{{ $occupation->id }}">
                                                  <div class="form-group">
                                                    <label>Occupation Name</label>
                                                    <input type="text" value="{{ $occupation->name }}" class="form-control" required name="name"  placeholder="Enter First Name">
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                            </div>
                                            </div>
                                        </div> --}}
                                        {{-- <a onclick="deleteRow('{{route('admin.mentor.occupation.delete',['id'=>$occupation->id])}}')"><i class="me-2 mdi mdi-delete"></i></a> --}}
                                    {{-- </td> --}}
                                </tr>
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
          </div>
        </div>



@endsection


<script>
    function deleteRow(url){
        var result = confirm("Are you sure you want to delete it?");
        if (result==true) {
        window.location.href=url;
        } else {
        return false;
        }
    }
</script>
@section('footerscript')
<script>

    $('.table').DataTable();
</script>
@endsection
