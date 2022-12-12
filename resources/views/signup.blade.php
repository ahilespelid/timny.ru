@extends('Frontend.layouts.loginlayout')
@section('content')
    @if(isset($fbEmail))
        <signup-page url={{$url}} fbemail={{$fbEmail}} fbid={{$fbId}}> </signup-page>
    @else
        <signup-page url={{$url}}> </signup-page>
    @endif


@endsection
