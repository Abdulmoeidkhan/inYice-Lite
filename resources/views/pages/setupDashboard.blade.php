@auth
@extends('layouts.layout')
@section("content")
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{$company->display_name}} Info</h5>
                <br />
                <p class="card-text">Contact : {{$company->contact}}</a></p>
                <p class="card-text">Email : {{$company->email}}</p>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <p class="card-text" style="font-size: 24px;">
                    <a href="tel:+{{$company->contact}}"><i class="ti ti-phone"></i></a>
                    <a href="mailto:{{$company->email}}"><i class="ti ti-mail"></i></a>
                </p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <x-image-upload-component
            name="{{Auth::user()->company->uuid}}"
            alt="{{Auth::user()->company->name}}'s Profile Picture"
            path=""
            disk="logo" />
    </div>
</div>
@endsection
@endauth