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

<h1>Company Information ({{$company->name}})</h1>

<br />

<livewire:form.form-wrapper
    :fields="[
        ['name' => 'display_name', 'label' => 'Display Company Name','value'=>$company->display_name, 'type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Enter Display Company Name']],
        ['name' => 'email', 'label' => 'Email','value'=>$company->email, 'type' => 'email', 'rules' => 'required|email', 'attributes' => ['placeholder' => 'Enter Company Email Address']],
        ['name' => 'image', 'label' => 'Company Logo', 'type' => 'file', 'rules' => 'nullable|image|max:1024'],
        ['name' => 'contact', 'label' => 'Contact Number', 'type' => 'tel', 'rules' => 'required|regex:/^[0-9+\-\s]+$/', 'attributes' => ['placeholder' => 'Contact Number']],
        ['name' => 'details_1_name', 'label' => 'Details 1 Name', 'type' => 'text', 'attributes' => ['placeholder' => 'Details 1 Name']],
        ['name' => 'details_1_value', 'label' => 'Details 1 Value', 'type' => 'textarea', 'attributes' => ['rows' => 3]],
        ['name' => 'industry', 'label' => 'Indutry', 'type' => 'select', 'options' => ['male' => 'Male', 'female' => 'Female']],
        ['name' => 'details_2_name', 'label' => 'Details 2 Name', 'type' => 'text', 'attributes' => ['placeholder' => 'Details 2 Name']],
        ['name' => 'details_2_value', 'label' => 'Details 2 Value', 'type' => 'textarea', 'attributes' => ['rows' => 3]],
        ['name' => 'country', 'label' => 'Country', 'type' => 'select', 'options' => ['1'=> 'Pakistan', '2' => 'India', '3' => 'USA'], 'rules' => 'required'],
        ['name' => 'city', 'label' => 'City','value'=>$company->city, 'type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Enter City']],
        ['name' => 'address', 'label' => 'Company Address','value'=>$company->address, 'type' => 'textarea', 'rules' => 'required',  'attributes' => ['rows' => 3]],
        ]"
        :className="$modelClass=App\Models\Company::class"
        submit-label="Register" />

@endsection
@endauth