@auth
@extends('layouts.layout')
@section("content")
<x-image-upload-component 
    name="{{Auth::user()->company->uuid}}"
    alt="{{Auth::user()->company->name}}'s Profile Picture"
    path=""
    disk="logo"
    />
@endsection
@endauth