@extends('new_admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Consultant Banks List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="">Home</a></li>
            <li class="breadcrumb-item active"> Consultant Banks</li>
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
            <div class="card">
                <div class="card-header-admin d-flex justify-content-between align-items-center">
                  <h3 class="card-title">Consultant Bank</h3>
                  {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#mentorOccupationModel" class="btn btn-primary mb-4 float-end">Add New</button> --}}

                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                    + Add New
                  </button>
                </div>

                <div class="modal fade" id="modal-default" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Consultant Banks</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p> <form action="{{route('admin.mentor.bank.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" class="form-control" required name="name"  placeholder="Enter Bank Name">
                              </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form></p>
                        </div>
                        {{-- <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div> --}}
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->


                <!-- /.card-header -->
                <div class="card-body">
                  <table id="admin_users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">SR. #</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                                $count = 1;
                            @endphp
                            @foreach ($banks as $bank)
                                <tr>
                                    <th>{{$count}}</th>
                                    <td>{{$bank->name}}</td>
                            <td>

                                {{-- <span  data-bs-toggle="modal" data-bs-target="#mentorOccupationEditModel_{{ $occupation->id }}" ><i class="fas fa-edit" data-id="{{ $occupation->id }}"></i></span> --}}
                                <a type="button" class="text-primary" data-toggle="modal" data-target="#mentorBankEditModel_{{ $bank->id }}">
                                    <i class="fas fa-edit" data-id="{{ $bank->id }}"></i>
                                </a>
                                <!-- Modal -->
                                <div  id="mentorBankEditModel_{{ $bank->id }}"
                                    class="modal fade"  aria-hidden="true" style="display: none;"

                                    >
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="mentorOccupationEditModelLabel">Edit Bank Model</h5>
                                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button> --}}
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('admin.mentor.bank.update')}}"  method="post">
                                                @csrf

                                          <input type="hidden" name="id"  value="{{ $bank->id }}">
                                          <div class="form-group">
                                            <label>Bank Name</label>
                                            <input type="text" value="{{ $bank->name }}"  class="form-control" required name="name"  placeholder="Enter Degree Name">
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                    </div>
                                    </div>
                                </div>
                                <a onclick="deleteRow('{{route('admin.mentor.bank.delete',['id'=>$bank->id])}}')"><i class="ml-3 text-danger fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @php
                            $count++;
                        @endphp
                    @endforeach
                    </tbody>
                    <tfoot>

                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('footer_script')
<script>
    $("#admin_users").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>

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
