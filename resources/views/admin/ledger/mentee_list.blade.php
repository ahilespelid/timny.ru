@extends('admin.layouts.app')

@section('content')
<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Mentee Appointment</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Mentee Appointment
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
                            <a href="{{route('admin.mentee.add')}}" class="btn btn-primary mb-4 float-end">Add New</a>
                        </div> --}}
                        <div class="clearfix"></div>
                    <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">SR. #</th>
                            <th scope="col">Name</th>
                            <th scope="col">Total Appointments Payment</th>
                            <th scope="col">View Details</th>
                        </tr>
                        </thead>
                        <tbody class="customtable">
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($mentees as $mentee)
                                <tr>
                                    <th>{{$count}}</th>
                                    @if(isset($mentee->user->first_name ))
                                        <td>{{$mentee->user->first_name . ' ' . $mentee->user->last_name }}</td>
                                        @else
                                       <td> {{$mentee->user->phone}}</td>
                                    @endif
                                    <td>
                                       {{$mentee->total_payment}}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.mentee-appointments', $mentee->user_id) }}"><i class="mdi mdi-table-edit"></i>View Appointments</a>
                                        {{-- <a onclick="deleteRow('{{route('admin.mentor.delete',['id'=>$mentee->user_id])}}')"><i class="me-2 mdi mdi-delete"></i></a> --}}
                                    </td>
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
@section('footerscript')
<script>

    $('.table').DataTable(
        {
            dom: 'Bfrtip',
            lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            {
                extend: 'copyHtml5',
                title: 'Appointment Ledger',
                 exportOptions: {
                    columns: ':not(:last-child)',
                    rows: ':visible'
                 }
            },
            {
                extend: 'excelHtml5',
                title: 'Appointment Ledger',
                exportOptions: {
                    columns: ':not(:last-child)',
                    rows: ':visible'
                 }
            },
            {
                extend: 'csvHtml5',
                title: 'Appointment Ledger',
                exportOptions: {
                    columns: ':not(:last-child)',
                    rows: ':visible'
                 }
            },
            {
                extend: 'pdfHtml5',
                title: 'Appointment Ledger',
                exportOptions: {
                    columns: ':not(:last-child)',
                    rows: ':visible'
                 }
            },
            {
                extend: 'print',
                title: 'Appointment Ledger',
                exportOptions: {
                    columns: ':not(:last-child)',
                    rows: ':visible'
                 }
            },
            'pageLength'
        ],
        select: true
        }
    );
</script>
@endsection
