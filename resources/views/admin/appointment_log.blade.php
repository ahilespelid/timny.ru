@extends('admin.layouts.app')

@section('content')

<!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
              <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Appointment Log List</h4>
                <div class="ms-auto text-end">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Appointment Log List
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
                        <div class="col-lg-12">
                            {{-- <a href="{{route('admin.blog.add')}}" class="btn btn-primary mb-4 float-end">Add New</a> --}}
                        </div>
                        <div class="clearfix"></div>
                    <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">SR. #</th>
                            <th scope="col">ID</th>

                            <th scope="col">Mentee</th>
                            <th scope="col">Mentor</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Payment</th>

                            <th scope="col">Type</th>
                            <th scope="col">Question</th>
                            <th scope="col">Appointment Status</th>


                        </tr>
                        </thead>
                        <tbody class="customtable">
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($appointments as $appointment )
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$appointment->id}}</td>

                                <td>{{!is_null($appointment->mentee->phone)?$appointment->mentee->phone:''}}</td>
                                <td>{{!is_null($appointment->mentor->first_name . " " . $appointment->mentor->last_name)?$appointment->mentor->first_name . " " . $appointment->mentor->last_name:''}}</td>
                                <td>{{$appointment->date}}</td>
                                <td>{{$appointment->time}}</td>
                                <td>{{$appointment->payment}}</td>
                                <td>{{$appointment->appointment_type_string}}</td>
                                <td>{{$appointment->questions}}</td>
                                <td>
                                    @if($appointment->appointment_status==0)
                                    Pending
                                    @elseif ($appointment->appointment_status==1)
                                    Accepted
                                    @elseif ($appointment->appointment_status==2)
                                    Completed
                                    @else
                                    Cancelled
                                    @endif

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


{{-- <script>
    function deleteRow(url){
        var result = confirm("Are you sure you want to delete it?");
        if (result==true) {
        window.location.href=url;
        } else {
        return false;
        }
    }
</script> --}}
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
                title: 'Appointment Log',
                 exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            {
                extend: 'excelHtml5',
                title: 'Appointment Log',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            {
                extend: 'csvHtml5',
                title: 'Appointment Log',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            {
                extend: 'pdfHtml5',
                title: 'Appointment Log',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                 }
            },
            {
                extend: 'print',
                title: 'Appointment Log',
                exportOptions: {
                    columns: ':visible',
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
