@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

<section class="bg-light">
    <div class="d-flex flex-column align-items-center justify-content-center px-4 py-5 mx-auto" style="min-height: 100vh;">
        {{-- <a href="#" class="d-flex align-items-center mb-4 text-dark">
            <img class="me-2" src="{{ asset('storage/images/logo.jpg') }}" alt="Job Hub" style="width: 32px; height: 32px;">
            Job Hub
        </a> --}}

        <div class="card w-100 shadow border-0" style="max-width: 28rem;">
            <div class="card-body p-4">
                <h1 class="h4 font-weight-bold text-dark mb-4">
                    Create an account
                </h1>
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('auth.register') }}" id="registerForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Your Name..." required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="name@company.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">Your Postal Code </label>
                        <input type="number" name="postal_code" id="postal_code" class="form-control" placeholder="postal code" required minlength="7">
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Your Phone </label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="phone number" required minlength="11">
                    </div>
                    <div class="mb-3">
                        <label for="birthday" class="form-label">Your birthday</label>
                        <input type="date" name="birthday" id="birthday" class="form-control"  required>
                    </div>
                    <div class="mb-3">address
                        <label for="birthday" class="form-label">Address</label>
                        <input type="string" name="address" id="address" class="form-control"  required>
                    </div>
                    <div class="mb-3">
                        <label for="occupation" class="form-label">Your occupation</label>
                        <input type="text" name="occupation" id="occupation" class="form-control"  required>
                    </div>

                  
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm password</label>
                        <input type="password" name="password_confirmation" id="confirm-password" class="form-control" placeholder="••••••••" required>
                    </div>

              

                    <button type="submit" form="registerForm" class="btn btn-primary w-100">Create an account</button>
                    <p class="text-center mt-3">
                        Already have an account? <a href="{{route('login')}}" class="text-primary">Login here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
