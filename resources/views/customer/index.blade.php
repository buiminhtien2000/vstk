@extends('master1')

@section('title', 'Khách hàng')

@section('style')
    @parent
@endsection

@section('content')
    <statistic url_get_pipeline="{{route('get_pipeline_by_user')}}"
                 url_get_sum_customer="{{route('sum_customer')}}"
                 url_get_sum_commission="{{route('sum_commission')}}"
                 url_get_customer_by_id="{{route('get_customer_by_id')}}"
                 url_get_contact_customer="{{route('get_contact_customer')}}"  
                 url_get_customer="{{route('get_customer')}}"></statistic>
@endsection

@section('script') 
@endsection