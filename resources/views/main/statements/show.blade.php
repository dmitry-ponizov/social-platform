@extends('layouts.app')

@section('content')

    <header-component></header-component>
    <nav-component :lang="{{json_encode(\Lang::get('main.nav_menu'))}}"></nav-component>
    <show-statement-component
            :statement="{{json_encode($statement)}}"
            locale="{{ \App::getLocale() }}"
            :lang="{{json_encode(\Lang::get('main.statement'))}}"
    >

        ></show-statement-component>
    <footer-component></footer-component>

@endsection
