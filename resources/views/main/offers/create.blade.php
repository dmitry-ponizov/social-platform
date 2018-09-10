@extends('layouts.app')

@section('content')
    <header-component></header-component>
    <nav-component :lang="{{json_encode(\Lang::get('main.nav_menu'))}}"></nav-component>
    <offer-create-component :answer="{{json_encode($answer)}}"></offer-create-component>
    <footer-component></footer-component>
@endsection
