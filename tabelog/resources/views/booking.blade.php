@extends('layouts.app')

@section('title')
    My Bookings
@endsection

@section('content')
<div class="container mt-5">
    <h1>My Bookings</h1>
    <div class="row">
        @foreach ($bookings as $booking)
        <div class="col-12 col-md-6 col-lg-4 my-4">
            <div class="card">
                <div class="card-body d-flex flex-row">
                    <h5 class="card-title font-weight-bold mb-2">{{ $booking->store->name }}</h5>
                </div>
                <div class="bg-image hover-overlay ripple rounded-0" data-mdb-ripple-color="light">
                    <img class="img-fluid" src="{{ asset('stores').'/'.$booking->store->image }}" />

                    
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                </div>
                <div class="card-body">
                    <p>Booking Date: {{ $booking->booking_time }}</p>
                    <p>Number of People: {{ $booking->people_count }}</p>
                    <a href="{{route('cancel-booking',$booking->id)}}" class=" btn btn-danger ">
                        cancel booking 
                    </a>
                    {{-- <p>Total Price: {{ $booking->total_price }}</p> --}}
                    
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
