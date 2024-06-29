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
    <h2 class="h4 font-weight-bold text-dark mt-2">Sign in to your account</h2>
  </div>

  <div class="container-sm w-100" style="max-width: 400px;">
    <form action="{{route('login')}}" method="POST" autocomplete="off">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input id="email" name="email" type="email" required autocomplete="off" class="form-control" placeholder="Enter your email">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" type="password" required class="form-control" placeholder="Enter your password">
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary w-100">Sign in</button>
      </div>
    </form>

    <p class="text-center mt-3">
      If you don't have an account, <a href="{{route('auth.register')}}" class="text-primary">register here</a>
      If you don't have an account, <a href="/forgot-password" class="text-primary">Forgot Password</a>
    </p>
  </div>
</div>
@endsection
