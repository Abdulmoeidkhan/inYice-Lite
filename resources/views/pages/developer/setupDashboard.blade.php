@auth
@extends('layouts.layout')
@section("content")
<div class="row">
    <div class="col-md-8">
        <div class="card">
            @if($company->display_name)
            <div class="card-body">
                <h5 class="card-title">{{$company->display_name}}</h5>
                <br />
                <p class="card-text">Contact : {{$company->contact}}</a></p>
                <p class="card-text">Email : {{$company->email}}</p>
                <p class="card-text">Industry : {{$company->industry}}</p>
                <p class="card-text">City : {{$company->city}}</p>
                <p class="card-text">Country : {{$company->countries->name}}</p>

                <p class="card-text">Owner : {{$company->owner->name ?? 'Not Assigned'}}</p>
                @if(isset($company->bank_details))
                <p class="card-text">Bank Details :{{$company->bank_details}} </p>
                @endif
                @if(isset($company->other_details))
                <p class="card-text">Other Details :{{$company->other_details}} </p>
                @endif
                <p class="card-text" style="font-size: 24px;">
                    <a href="tel:+{{$company->contact}}"><i class="ti ti-phone"></i></a>
                    <a href="mailto:{{$company->email}}"><i class="ti ti-mail"></i></a>
                    @foreach($company->social_links as $key => $link)
                    @if($link)
                    <a href="{{$link}}" target="_blank" title="{{$key}}"><i class="ti ti-brand-{{strtolower(str_replace(['/', 'X'], ['', 'x'], $key))}}"></i></a>
                    @endif
                    @endforeach
                </p>
                <a href="/setup/company/{{Auth::user()->company->uuid}}/edit" class="btn btn-primary">Update Company Information</a>
            </div>
            @else
            <div class="card-body">
                <h5 class="card-title">No Company Information Available</h5>
                <p class="card-text">Please update your company information.</p>
                <a href="/setup/company/{{Auth::user()->company->uuid}}/edit" class="btn btn-primary">Update Company Information</a>
            </div>
            @endif
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