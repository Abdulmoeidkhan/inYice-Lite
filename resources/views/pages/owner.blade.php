@auth
@extends('layouts.layout')
@section("content")

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/setup">Developer</a></li>
        <li class="breadcrumb-item"><a href="/setup/company">{{$company->code}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$company->name}}</li>
    </ol>
</nav>

<livewire:ui.alert-component />

<h1>Owner's Information ({{$company->name}})</h1>

<br />
<h2>New Owner Information </h2>
<livewire:form.form-wrapper
    :fields="[
        ['name' => 'name', 'label' => 'Owner Name', 'type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Enter Owner Name']],
        ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'rules' => 'required|email', 'attributes' => ['placeholder' => 'Owner Email Address']],
        ['name' => 'contact', 'label' => 'Contact Number', 'type' => 'tel', 'rules' => 'required|regex:/^[0-9+\-\s]+$/', 'attributes' => ['placeholder' => 'Contact Number']],
        ['name' => 'company_uuid','label'=>'Company UUID', 
        'type' => 'hidden','defaultValue'=>$company->uuid, 'rules' => 'required'],
        ]"
    :className="App\Models\User::class"
    :additionalFunctions="['afterSaveFunction'=>'assignRole']"
    additionalFunctionValue="owner"
    wire:key="{{ rand() }}"
    submitLabel="Register" />
<br />
<br />
@if($users->count()>0)
@foreach($users as $key=>$user)
<h2>Owner {{$key+1}} Information ({{$user->name}}) </h2>
<div class="row">
    <div class="mx-auto col-12 col-lg-8 col-md-8">
        <livewire:form.form-wrapper
            :fields="[
        ['name' => 'name', 'label' => 'Owner Name', 'type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Enter Owner Name']],
        ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'rules' => 'required|email', 'attributes' => ['placeholder' => 'Owner Email Address']],
        ['name' => 'contact', 'label' => 'Contact Number', 'type' => 'tel', 'rules' => 'required|regex:/^[0-9+\-\s]+$/', 'attributes' => ['placeholder' => 'Contact Number']],
        ]"
            :className="App\Models\User::class"
            :uuid="$user->uuid"
            wire:key="{{ rand() }}"
            submitLabel="Update" />
    </div>
    <div class="mx-auto col-12 col-lg-4 col-md-4">
        <x-image-upload-component
            name="{{$user->uuid}}"
            alt="{{$user->name}}'s Profile Picture"
            path=""
            disk="staff" />
    </div>
</div>
@endforeach
@else
<h2>No Owner Registered Yet!</h2>
@endif

@endsection
@endauth