@extends('layouts.app')

@section('content')
    <header-component></header-component>
    <nav-component :lang="{{json_encode(\Lang::get('main.nav_menu'))}}"></nav-component>
    <donate-component
            :statements="{{json_encode($statements)}}"
            :statement="{{json_encode($statement)}}"
            :categories="{{json_encode($categories)}}"
            :locale="{{ json_encode(\App::getLocale()) }}"
            :lang="{{json_encode($lang)}}"></donate-component>
    <footer-component></footer-component>
@endsection