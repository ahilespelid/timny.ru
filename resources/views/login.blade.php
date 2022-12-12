@php
   $settings= DB::table('settings')->where('name' , 'login_type')->first();
   $login_type = $settings->value;


@endphp

@extends('Frontend.layouts.loginlayout')
@section('content')
    @if (isset($user_id))
        <login-page url={{$url}} login_type={{$login_type}} user_id={{$user_id}} access_token={{$access_token}}> </login-page>
    @else
    <login-page login_type={{$login_type}} url={{$url}}> </login-page>
    @endif


@endsection
