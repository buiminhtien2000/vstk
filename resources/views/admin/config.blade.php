@extends('master1')

@section('title', 'Setting')

@section('style')
    @parent
@endsection

@section('content')
    <config 
    url_get_pipeline="{{route('get_pipeline')}}"
    url_get_deal_field="{{route('get_deal_field')}}"
    url_get_config_field="{{route('get_config_field')}}" 
    url_get_config_commission="{{route('get_config_commission')}}"
    url_save_config_field="{{route('save_config_field')}}" 
    url_save_config_commission="{{route('save_config_commission')}}"></config>
@endsection

@section('script')
@endsection 