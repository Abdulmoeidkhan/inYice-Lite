@auth
@extends('layouts.layout')
@section("content")


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">{{$company->name}}</a></li>
        <li class="breadcrumb-item" aria-current="page">Users</li>
    </ol>
</nav>

<livewire:ui.alert-component />

<h1>{{$company->name}} Users</h1>

<br />
<h2> New Users </h2>
<br />

<livewire:form.form-wrapper
    :fields="[
        ['name' => 'name', 'label' => 'Name','type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Name']],
        ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'rules' => 'required|email', 'attributes' => ['placeholder' => 'Email Address']],
        ['name' => 'contact', 'label' => 'Contact Number','type' => 'tel', 'rules' => 'required|regex:/^[0-9+\-\s]+$/', 'attributes' => ['placeholder' => 'Contact Number']],
        ['name' => 'company_uuid','label'=>'Company UUID', 
        'type' => 'hidden','defaultValue'=>$company->uuid, 'rules' => 'required'],
        ]"
    :className="App\Models\User::class"
    :additionalFunctions="['afterSaveFunction'=>'assignRole']"
    additionalFunctionValue="user"
    submitLabel="Create"
    :pullValues="['name', 'email', 'contact']"
    wire:key="{{ rand() }}" />
<br />

<h2> Existing Users </h2>
<br />
<x-table-component requestUrl="request.users.index" editRoute='pages.admin.users.edit' deleteRoute='pages.admin.users.destroy' :subColumns="['name']" :columns="[
    ['label'=>'Name','name'=>'name','function'=>'operateText','searchable'=>true],
    ['label'=>'Email','name'=>'email','function'=>'operateEmail','searchable'=>true],
    ['label'=>'Contact','name'=>'contact','function'=>'operateContact','searchable'=>true],
    ['label'=>'Roles','name'=>'roles','function'=>'operateArray','searchable'=>true],
    ['label'=>'Image','name'=>'image','function'=>'operatePicture'],
    ['label'=>'Quick Edit','name'=>'uuid','function'=>'operateQuickEdit','right'=>'users-edit'],
    ['label'=>'Edit','name'=>'uuid','function'=>'operateEdit','right'=>'users-edit'],
    ]" />
@endsection
@endauth