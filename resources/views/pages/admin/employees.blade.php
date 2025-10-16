@auth
@extends('layouts.layout')
@section("content")


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">{{$company->name}}</a></li>
        <li class="breadcrumb-item" aria-current="page">Employees</li>
    </ol>
</nav>

<livewire:ui.alert-component />

<h1>{{$company->name}} Employees</h1>

<br />
<h2> New Employees </h2>
<br />

<livewire:form.form-wrapper
    :fields="[
        ['name' => 'user_uuid', 'label' => 'Users','type' => 'select', 'options' => \App\Models\User::role('user')->pluck('name', 'uuid')->toArray()],
        ['name' => 'designation', 'label' => 'Designation','type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Designation']],
        ['name' => 'wage', 'label' => 'Wages', 'type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Wages']],
        ['name' => 'duty', 'label' => 'Duty','type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Duty']],
        ['name' => 'remarks', 'label' => 'Remarks','type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Remarks']],
        ]"
    :className="App\Models\Employee::class"
    submitLabel="Assign Employee"
    :pullValues="['user_uuid', 'designation', 'wage', 'duty', 'remarks']"
    wire:key="{{ rand() }}" />
<br />

<h2> Existing Employees </h2>
<br />
<x-table-component requestUrl="request.employees.index" editRoute='pages.admin.employees.edit' :subColumns="['name']" :columns="[
    ['label'=>'Name','name'=>'name','function'=>'operateText','searchable'=>true],
    ['label'=>'Designation','name'=>'employee.designation','function'=>'operateText','searchable'=>true],
    ['label'=>'Wage','name'=>'employee.wage','function'=>'operateText','searchable'=>true],
    ['label'=>'Duty','name'=>'employee.duty','function'=>'operateText','searchable'=>true],
    ['label'=>'Remarks','name'=>'employee.remarks','function'=>'operateText','searchable'=>true],
    ['label'=>'Edit','name'=>'uuid','function'=>'operateEdit','right'=>'users-edit'],
    ]" />
@endsection
@endauth