@auth
@extends('layouts.layout')
@section("content")


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">{{$company->name}}</a></li>
        <li class="breadcrumb-item"><a href="/admin/users">Users</a></li>
        <li class="breadcrumb-item" aria-current="page">{{$user->name}}</li>
    </ol>
</nav>

<livewire:ui.alert-component />

<h1>{{$user->name}} Profile</h1>

<br />

@endsection
@endauth