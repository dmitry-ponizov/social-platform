@extends('layouts.app')

@section('content')

    <header-component></header-component>
    <nav-component :lang="{{json_encode(\Lang::get('main.nav_menu'))}}"></nav-component>
    <organization-details
            :organization="{{ $organization }}"
            locale="{{ \App::getLocale() }}">
    </organization-details>
    <footer-component></footer-component>

@endsection