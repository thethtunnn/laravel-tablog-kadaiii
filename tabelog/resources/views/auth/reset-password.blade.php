@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
<div class="d-flex min-vh-100 flex-column justify-content-center px-4 py-5 lg:px-8">

  @if($errors->any())
    <ul class="alert alert-danger">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  <div class="text-center mb-4">
    {{-- <img src="{{ asset('storage/images/logo.jpg') }}" class="h-8" alt="Job Hub" /> --}}
    <h2 class="h4 font-weight-bold text-dark mt-2">Reset Your Password</h2>
  </div>

  <div class="container-sm w-100" style="max-width: 400px;">
    <form action="{{route('password.update')}}" method="POST" autocomplete="off">
      @csrf
      <input type="text" name="token" hidden value="{{$token}}">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input id="email" name="email" type="email" required autocomplete="off" class="form-control" placeholder="Enter your email">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" type="password" required class="form-control" placeholder="Enter your password">
      </div>
      <div class="mb-3">
        <label for="confirm-password" class="form-label">Confirm password</label>
        <input type="password" name="password_confirmation" id="confirm-password" class="form-control" placeholder="••••••••" required>
    </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary w-100">Sign in</button>
      </div>
    </form>

  </div>
</div>
@endsection
