@extends('layouts.app')

@section('content')
    <header-component></header-component>
    <nav-component></nav-component>
    <organizations :organizations="{{ json_encode($organizations) }}"></organizations>
    <footer-component></footer-component>
@endsection