@extends('layouts.app')

@section('content')

    <header-component></header-component>
    <nav-component></nav-component>
    <slider-component :slides="{{json_encode($sliders)}}"></slider-component>
    <banner-component></banner-component>
    <welcome-block-component></welcome-block-component>
    <finance-statement-component :statements="{{json_encode($finance_statements)}}" :locale="{{ json_encode(\App::getLocale()) }}"></finance-statement-component>
    <quick-donate-component :categories="{{json_encode($categories)}}"></quick-donate-component>
    <service-component :statements="{{json_encode($last_statements)}}"></service-component>
    <statistics-component></statistics-component>
    <volunteers-component :volunteers="{{json_encode($volunteers)}}"></volunteers-component>
    <become-volunteer :statements="{{json_encode($finance_statements)}}"></become-volunteer>
    <partners-component :partners="{{json_encode($partners['data'])}}" ></partners-component>
    <footer-component></footer-component>

@endsection
