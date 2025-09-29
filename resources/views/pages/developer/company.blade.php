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

<h1>Company Information ({{$company->name}})</h1>
<br />
<livewire:form.form-wrapper
    :fields="[
        ['name' => 'display_name', 'label' => 'Display Company Name','type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Enter Display Company Name']],
        ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'rules' => 'required|email', 'attributes' => ['placeholder' => 'Enter Company Email Address']],
        ['name' => 'contact', 'label' => 'Contact Number','type' => 'tel', 'rules' => 'required|regex:/^[0-9+\-\s]+$/', 'attributes' => ['placeholder' => 'Contact Number']],
        ['name' => 'industry', 'label' => 'Industry', 'type' => 'select', 'options' => ['agency' => 'Travel Agency', 'aviation' => 'Aviation']],
        ['name' => 'country', 'label' => 'Country', 'type' => 'select', 'options' => \App\Models\Country::all()->pluck('name', 'id')->toArray()],
        ['name' => 'city', 'label' => 'City','type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Enter City']],
        ['name' => 'details_1_value', 'label' => 'Bank Details', 'type' => 'textarea', 'attributes' => ['rows' => 3]],
        ['name' => 'details_2_value', 'label' => 'Other Details', 'type' => 'textarea', 'attributes' => ['rows' => 3]],
        ['name' => 'address', 'label' => 'Company Address','type' => 'textarea', 'rules' => 'required',  'attributes' => ['rows' => 3]],
        ['name' => 'owner_uuid','label' => 'Owner','type' => 'select','options' => App\Models\User::role('owner')->get()->pluck('name', 'uuid')->toArray(),],
        ['name' => 'social_links', 'label' => 'Social Links','type' => 'textarray','dataKeys'=> ['Facebook', 'Instagram', 'Whatsapp', 'TikTok', 'Snapchat','Twitter/X', 'LinkedIn', 'YouTube', 'Telegram', 'Pinterest','Reddit', 'Discord', 'Medium']],]"
    :className="App\Models\Company::class"
    :uuid="$company->uuid"
    submitLabel="Update"
    wire:key="{{ rand() }}" />

@endsection
@endauth