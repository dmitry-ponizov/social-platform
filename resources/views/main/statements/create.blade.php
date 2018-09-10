@extends('layouts.app')

@section('content')

    <header-component></header-component>
    <nav-component></nav-component>
    <statement-create-component :answer="{{json_encode($answer)}}" ></statement-create-component>
    <footer-component></footer-component>

@endsection
