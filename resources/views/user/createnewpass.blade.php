@extends('master2')

@section('title', 'Thành công!')

@section('style')
    @parent
@endsection

@section('content')
    <newpassword url_reset ="{{route('confirm_reset')}}"></newpassword>
@endsection

@section('script')
@endsection