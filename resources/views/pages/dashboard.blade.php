@auth
@extends('layouts.layout')
@section("content")
Hello, {{ auth()->user()->name }}! Welcome to your dashboard.
@endsection
@endauth