@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile Information</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Address:</strong> {{ $user->address ?? 'Not provided' }}</p>
                    <p><strong>Postal Code:</strong> {{ $user->postal_code ?? 'Not provided' }}</p>
                    <p><strong>Phone Number:</strong> {{ $user->phone_number ?? 'Not provided' }}</p>
                    <p><strong>Date of Birth:</strong> {{ $user->birthday ?? 'Not provided' }}</p>
                    <p><strong>Occupation:</strong> {{ $user->occupation ?? 'Not provided' }}</p>
                    <a href="{{ route('edit-profile') }}" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
