@auth
@extends('layouts.layout')
@section("content")


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">{{$company->name}}</a></li>
        <li class="breadcrumb-item"><a href="/admin/employees">Employees</a></li>
        <li class="breadcrumb-item" aria-current="page">{{$employee->user->name}}</li>
    </ol>
</nav>

<livewire:ui.alert-component />

<h1>{{$employee->user->name}} Profile</h1>

<br />

<style>
    .box,
    .box-representatives {
        padding: 0.5em;
        width: 100%;
        margin: 0.5em;
    }

    .box-2,
    .box-2-representatives {
        padding: 0.5em;
        width: calc(100%/2 - 1em);
    }

    .hide,
    .hide-representatives {
        display: none;
    }

    img {
        max-width: 100%;
    }
</style>
<div id="liveAlertPlaceholder"></div>
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Employee Information</h5>
                <div class="table-responsive">
                    <form name="userBasicInfo" id="userBasicInfo">
                        <fieldset>
                            <legend>General Information</legend>
                            @csrf
                            <div class="mb-3">
                                <label for="disabledInputEmail1" class="form-label">Registered Email Address</label>
                                <input name="disabledInputEmail1" type="email" class="form-control" id="disabledInputEmail1" placeholder="Registered Email Address" aria-describedby="emailHelp" value="{{$employee->user->email}}" disabled>
                                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                            </div>
                            <div class="mb-3">
                                <label for="inputUserName" class="form-label">Your User Name</label>
                                <input name="inputUserName" type="text" class="form-control" id="inputUserName" placeholder="User Name" aria-describedby="userHelp" value="{{$employee->user->name}}" minlength="3" maxlength="20" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Your Contact Number</label>
                                <input type="text" name="inputContactNumber" class="form-control" id="contact" placeholder="Contact Number" aria-describedby="userHelp" value="{{$employee->user->contact}}" minlength="14" maxlength="14" required>
                            </div>
                            <input type="hidden" name="uid" value="{{$employee->user->uid}}" />
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@endauth