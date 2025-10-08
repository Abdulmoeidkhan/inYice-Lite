@auth
@extends('layouts.layout')
@section("content")
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @if($company->display_name)
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
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
                            @if(isset($company->social_links) && is_array($company->social_links))
                            @foreach($company->social_links as $key => $link)
                            @if($link)
                            <a href="{{$link}}" target="_blank" title="{{$key}}"><i class="ti ti-brand-{{strtolower(str_replace(['/', 'X'], ['', 'x'], $key))}}"></i></a>
                            @endif
                            @endforeach
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4 text-center card">
                        @if(Storage::disk('logo')->exists(Auth::user()->company->uuid.'.png'))
                        <img  id="basicImg_{{Auth::user()->company->uuid}}" src="{{Storage::disk('logo')->url(Auth::user()->company->uuid.'.png')}}" width="200px" height="200px" class="rounded mx-auto d-block" alt="{{Auth::user()->company->name}}'s Profile Picture">
                        @else
                        <img id="basicImg_{{Auth::user()->company->uuid}}" src="{{asset('assets/images/profile/user-1.jpg')}}" width="200px" height="200px" class="rounded mx-auto d-block" alt="{{Auth::user()->company->name}}'s Profile Picture">
                        @endIf
                    </div>
                </div>
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
</div>
@endsection
@endauth