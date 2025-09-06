@extends('layouts.layout')
@section("content")
<style>
  .gradient-class {
    background: #2BC0E4;
    background: -webkit-linear-gradient(to right, #EAECC6, #2BC0E4);
    background: linear-gradient(to right, #EAECC6, #2BC0E4);
  }
</style>
<div class="page-wrapper gradient-class" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
  <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
          <div class="card mb-0" style="border-radius: 30px;box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;">
            <div class="card-body">
              @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div>{{session('error')}}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @elseif(session('message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>{{session('message')}}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @endif
              <a href="{{route('pages.dashboard')}}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                <img src="{{asset('assets/images/logos/logo.png')}}" width="180" alt="Badar">
              </a>
              <p class="text-center">Account Management System</p>
              <form action="{{route('request.login')}}" method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus aria-describedby="emailHelp">
                  @error('email')<span class="text-badar">
                    {{ $message }}
                  </span>@enderror
                </div>
                <div class="mb-4">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password">
                  @error('password')<span class="text-badar">
                    {{ $message }}
                  </span>@enderror
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="form-check">
                    <input class="form-check-input badar" type="checkbox" value="" id="flexCheckChecked" checked>
                    <label class="form-check-label text-dark" for="flexCheckChecked">
                      Remeber this Device
                    </label>
                  </div>
                  <a class="text-badar fw-bold" href="#">Forgot Password ?</a>
                </div>
                @csrf
                <input type="submit" name="Sign In" value="Sign In" class="btn btn-badar w-100 py-8 fs-4 mb-4 rounded-2" />
                {{-- <div class="d-flex align-items-center justify-content-center">
                  <p class="fs-4 mb-0 fw-bold">Activate Account?</p>
                  <a class="text-badar fw-bold ms-2" href="{{route('accountActivation')}}">Activate</a>
            </div> --}}
            </form>
            <br />
            <a class="btn btn-light w-100 py-8 fs-4 mb-4 rounded-2" href="{{ route('request.google') }}" target="_blank">
              <!-- <i class="ti ti-brand-google" style="vertical-align: bottom; font-size:24px; font-weight:bolder;  background: linear-gradient(-120deg, #4285f4, #34a853, #fbbc05, #ea4335);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  display: inline-block;"></i>  -->
              <img height="24px" src="{{asset('assets/images/logos/google.png')}}" />
              &nbsp;
              Sign in with Google
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection