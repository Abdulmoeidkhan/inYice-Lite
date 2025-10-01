@auth
@extends('layouts.layout')
@section("content")


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">{{$company->name}}</a></li>
        <li class="breadcrumb-item"><a href="/admin/users">Users</a></li>
        <li class="breadcrumb-item" aria-current="page">{{$user->name}}</li>
    </ol>
</nav>

<livewire:ui.alert-component />

<h1>{{$user->name}} Profile</h1>

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
    <div class="col-lg-4">
        <x-image-upload-component
            name="{{$user->uuid}}"
            alt="{{$user->name}}'s Profile Picture"
            path=""
            disk="staff" />
    </div>
    <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Profile Information</h5>
                <div class="table-responsive">
                    <form name="userBasicInfo" id="userBasicInfo">
                        <fieldset>
                            <legend>General Information</legend>
                            @csrf
                            <div class="mb-3">
                                <label for="disabledInputEmail1" class="form-label">Registered Email Address</label>
                                <input name="disabledInputEmail1" type="email" class="form-control" id="disabledInputEmail1" placeholder="Registered Email Address" aria-describedby="emailHelp" value="{{$user->email}}" disabled>
                                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                            </div>
                            <div class="mb-3">
                                <label for="inputUserName" class="form-label">Your User Name</label>
                                <input name="inputUserName" type="text" class="form-control" id="inputUserName" placeholder="User Name" aria-describedby="userHelp" value="{{$user->name}}" minlength="3" maxlength="20" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Your Contact Number</label>
                                <input type="text" name="inputContactNumber" class="form-control" id="contact" placeholder="Contact Number" aria-describedby="userHelp" value="{{$user->contact}}" minlength="14" maxlength="14" required>
                            </div>
                            <input type="hidden" name="uid" value="{{$user->uid}}" />
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                        </fieldset>
                    </form>
                </div>
                <br />
                <div class="table-responsive">
                    <form name="userPasswordInfo" id="userPasswordInfo">
                        <fieldset>
                            <legend>Password Information</legend>
                            @csrf
                            <div class="mb-3">
                                <label for="userInputPassword" class="form-label">Password</label>
                                <input type="password" name="userInputPassword" onkeypress="checkPasswordStrength(this)" class="form-control" id="userInputPassword" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            </div>
                            <div class="mb-3">
                                <label for="userInputPasswordConfirm" class="form-label">Confirm Password</label>
                                <input type="password" name="userInputPasswordConfirm" onkeypress="checkPasswordStrength(this)" class="form-control" id="userInputPasswordConfirm" placeholder="Confirm Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            </div>
                            <input type="hidden" name="uuid" value="{{$user->uuid}}" required />
                            <input type="submit" name="submit" class="btn btn-badar" value="Change" />
                        </fieldset>
                    </form>
                </div>
                <br />
                <div>
                    <form class="form-roles">
                        <fieldset>
                            <legend>Roles</legend>
                            @csrf
                            <div class="mb-3">
                                <label for="roleSelect" class="form-label">Roles</label>
                                <select id="roleSelect" name="roles" class="form-select text-capitalize">
                                    @foreach(\Spatie\Permission\Models\Role::all() as $selectiveRole)
                                    <option value="{{$selectiveRole->name}}" {{$user->roles[0]->name === $selectiveRole->name ? 'selected' : ''}}>{{$selectiveRole->name}}</option>
                                    {{$selectiveRole->name}}
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="uuid" value="{{$user->uuid}}" required />
                            <input type="submit" class="btn btn-danger" value="Authorise" />
                        </fieldset>
                    </form>
                </div>
                <br />
                <div>
                    <form class="form-permissions">
                        <fieldset>
                            <legend>Permissions</legend>
                            @csrf
                            <div class="row">
                                @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
                                <label class="col-lg-3 col-md-6 col-sm-6 col-xs-12 text-capitalize mb-2">
                                    <input type="checkbox" name="permissions[]" value="{{$permission->name}}" {{ $user->hasRole($selectiveRole->name) ? 'checked' : '' }}><span style="">{{$permission->name}}</span>
                                </label>
                                @endforeach
                            </div>
                            <input type="hidden" name="uuid" value="{{$user->uuid}}" required />
                            <input type="submit" class="btn btn-danger" value="Authorise" />
                        </fieldset>
                    </form>
                </div>
                <script async src="{{asset('assets/js/formValidations.js')}}"></script>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector('.form-roles').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        axios.post("{{ route('request.attachRole') }}", formData)
            .then(function(response) {
                console.log(response);
            })
            .catch(function(error) {
                console.log(error);
            });
    });
</script>

@endsection
@endauth