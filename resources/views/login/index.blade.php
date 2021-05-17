@extends('master2')

@section('title', 'Đăng nhập')

@section('style')
    @parent
@endsection

@section('content')
    <login route_store="{{ route('login')}}" user_remember = "{{(isset($_COOKIE['user']))?$_COOKIE['user']:'false'}}" ></login>
@endsection

@section('script')
@endsection