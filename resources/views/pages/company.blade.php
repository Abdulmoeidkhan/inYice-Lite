@auth
@extends('layouts.layout')
@section("content")

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/setup">Developer</a></li>
        <li class="breadcrumb-item"><a href="/setup/company">{{$company->code}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Information</li>
    </ol>
</nav>

<h1>Company Information</h1>

<br />

<livewire:form.form-wrapper
    :fields="[
        ['name' => 'owner', 'label' => 'Owner', 'type' => 'select', 'options' => $users],
        ['name' => 'name', 'label' => 'Company Name','value'=>$company->name, 'type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Enter Company Name','disabled'=>true]],
        ['name' => 'display_name', 'label' => 'Display Company Name','value'=>$company->display_name, 'type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Enter Display Company Name']],
        ['name' => 'email', 'label' => 'Email','value'=>$company->email, 'type' => 'email', 'rules' => 'required|email', 'attributes' => ['placeholder' => 'Enter Company Email Address']],
        ['name' => 'image', 'label' => 'Company Logo', 'type' => 'file', 'rules' => 'nullable|image|max:1024'],
        ['name' => 'contact', 'label' => 'Contact Number', 'type' => 'tel', 'rules' => 'required|regex:/^[0-9+\-\s]+$/', 'attributes' => ['placeholder' => 'Contact Number']],
        ['name' => 'gender', 'label' => 'Gender', 'type' => 'select', 'options' => ['male' => 'Male', 'female' => 'Female']],
        ['name' => 'bio', 'label' => 'Bio', 'type' => 'textarea', 'attributes' => ['rows' => 3]],
    ]"
    :className="$modelClass=App\Models\Company::class"
    submit-label="Register" />
<br />
<form method="POST" enctype="multipart/form-data" class="container mt-4">
    @csrf
    <div class="row g-3">
        <!-- Row 1 -->
        <div class="col-12 col-lg-4">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="" disabled>
        </div>

        <div class="col-12 col-lg-4">
            <label for="owner_uuid" class="form-label">Owner</label>
            <select class="form-select" id="owner_uuid" name="owner_uuid">
                <option value="">Select Owner</option>
                <!-- Add owner options here -->
            </select>
        </div>
        <div class="col-12 col-lg-4">
            <label for="display_name" class="form-label">Display Name</label>
            <input type="text" class="form-control" id="display_name" name="display_name">
        </div>

        <!-- Row 2 -->
        <div class="col-12 col-lg-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="example@email.com">
        </div>
        <div class="col-12 col-lg-4">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" accept=".jpeg,.jpg,.png,.webp">
        </div>
        <div class="col-12 col-lg-4">
            <label for="contact" class="form-label">Contact</label>
            <input type="tel" class="form-control" id="contact" name="contact" pattern="[0-9+\-\s]+" placeholder="Contact Number">
        </div>

        <!-- Row 3 -->
        <div class="col-12 col-lg-4">
            <label for="industry" class="form-label">Industry</label>
            <input type="text" class="form-control" id="industry" name="industry">
        </div>
        <div class="col-12 col-lg-4">
            <label for="code" class="form-label">Code</label>
            <input type="text" class="form-control" id="code" name="code" value="WA15955706">
        </div>
        <div class="col-12 col-lg-4">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address">
        </div>

        <!-- Row 4 -->
        <div class="col-12 col-lg-4">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city">
        </div>
        <div class="col-12 col-lg-4">
            <label for="country" class="form-label">Country</label>
            <select class="form-select" id="country" name="country">
                <option value="">Select Country</option>

            </select>
        </div>
        <div class="col-12 col-lg-4">
            <label for="details_1_name" class="form-label">Details 1 Name</label>
            <input type="text" class="form-control" id="details_1_name" name="details_1_name">
        </div>

        <!-- Row 5 -->
        <div class="col-12 col-lg-4">
            <label for="details_1_value" class="form-label">Details 1 Value</label>
            <input type="text" class="form-control" id="details_1_value" name="details_1_value">
        </div>
        <div class="col-12 col-lg-4">
            <label for="details_2_name" class="form-label">Details 2 Name</label>
            <input type="text" class="form-control" id="details_2_name" name="details_2_name">
        </div>
        <div class="col-12 col-lg-4">
            <label for="details_2_value" class="form-label">Details 2 Value</label>
            <input type="text" class="form-control" id="details_2_value" name="details_2_value">
        </div>
    </div>
    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

@endsection
@endauth