{{-- <link rel="stylesheet" href="{{ asset('/new_admin/plugins/toastr/toastr.min.css') }}">
<script src="{{ asset('/new_admin/plugins/toastr/toastr.min.js') }}"></script> --}}
<link rel="stylesheet" href="{{ asset('/css/iziToast.min.css') }}">
<script src="{{ asset('/js/iziToast.min.js') }}"></script>


@if(session()->has('notify'))
    @foreach(session('notify') as $msg)
        <script type="text/javascript">
            "use strict";
            toastr.info("{{$msg[1]}}"")
            iziToast.{{ $msg[0] }}({message:"{{ trans($msg[1]) }}", position: "topRight"});
        </script>
    @endforeach
@endif

@if ($errors->any())
    @php
        $collection = collect($errors->all());
        $errors = $collection->unique();
    @endphp

    <script>
        "use strict";
        @foreach ($errors as $error)
        iziToast.error({
            message: '{{ $error }}',
            position: "topRight"
        });
        toastr.info("{{ $error}}"")
        @endforeach
    </script>

@endif
<script>
    "use strict";
    function notify(status,message) {
        iziToast[status]({
            message: message,
            position: "topRight"
        });
    }
</script>
