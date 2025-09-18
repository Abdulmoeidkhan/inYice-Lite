@auth
@extends('layouts.layout')
@section("content")


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">{{$company->name}}</a></li>
        <li class="breadcrumb-item"><a href="/admin/users">Users</a></li>
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


<livewire:ui.list-component
    title="Users List"
    searchPlaceholder="Name/Email/Contact"
    :className="App\Models\User::class"
    :filters="['company_uuid'=>$company->uuid]"
    :relations="['roles','permissions']"
    :columns="[
        ['label'=>'Name', 'field'=>'name', 'type'=>'text'],
        ['label'=>'Email', 'field'=>'email', 'type'=>'text'],
        ['label'=>'Contact', 'field'=>'contact', 'type'=>'text'],
        ['label'=>'Role(s)', 'field'=>'roles', 'type'=>'relation', 'relationField'=>'name', 'isArray'=>true],
        ['label'=>'Created At', 'field'=>'created_at', 'type'=>'datetime'],
        ['label'=>'Actions', 'field'=>'actions', 'type'=>'actions', 'actions'=>[
            ['label'=>'Edit', 'type'=>'link', 'urlPrefix'=>'/admin/users/', 'urlField'=>'uuid', 'icon'=>'ti ti-edit', 'class'=>'btn btn-sm btn-primary'],
            ]],
        ]"
    :orderBy="['field'=>'created_at', 'direction'=>'desc']"
    wire:key="{{ rand() }}" />
@endsection
@endauth