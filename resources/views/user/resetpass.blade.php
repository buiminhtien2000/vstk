@extends('master2')

@section('title', 'Quên mật khẩu')

@section('style')
    @parent
@endsection

@section('content')
    <resetpass url_create_link_reset="{{ route('link_reset')}}" url_check_user="{{ route('check_email_user')}}"></resetpass>
@endsection

@section('script')
@endsection