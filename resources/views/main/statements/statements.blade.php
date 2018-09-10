@extends('layouts.app')

@section('content')

    <header-component></header-component>
    <nav-component  :lang="{{json_encode(\Lang::get('main.nav_menu'))}}"></nav-component>
    <statements-wrapper-component
            :categories="{{json_encode($categories)}}"
            :stats="{{json_encode($stats)}}"
            :lang="{{json_encode(\Lang::get('main.statement'))}}">
    </statements-wrapper-component>
    <footer-component></footer-component>

@endsection
