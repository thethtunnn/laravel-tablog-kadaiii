@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="row justify-content-center">
            <div class="col-8">
               
               
                    
                            <div class="">
                                <div class="card-body d-flex flex-row">
                                    <h5 class="card-title font-weight-bold mb-2">{{ $item->name }}</h5>
                                </div>
                                <div class="bg-image hover-overlay ripple rounded-0" data-mdb-ripple-color="light">
                                    <a href="{{ route('meals.show', $item->id) }}">
                                        <img class="img-fluid cus_img" src="{{ asset('stores').'/'.$item->image }}" />
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <span class="">{{ $item->lowest_price }} ¥ to  {{$item->highest_price}} ¥</span>
                                        <p>
                                            located at {{$item->Address}}
                                        </p>
                                        <p>
                                            {{$item->opening_time}} to {{$item->closing_time}}
                                        </p>
                                        <p>
                                            Seat {{$item->seating_capacity}}
                                        </p>
                                        
                                        <form action="{{ url('/make_fav/' . $item->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" style="border: none; background: none; padding: 0;">
                                             @auth
                                                 
                                             <i class="fa-solid fa-heart h5 {{ auth()->user()->hasFavoritedMeal($item->id) ? 'favorited' : '' }}"></i>
                                             @endauth
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                  
                
                </div>
          
            <div class="col-4">
                <form id="booking-form" action="{{ route('order_meal', $item->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="booking-date">Select Date</label>
                        <input type="datetime-local" class="form-control" id="booking-date" name="booking_time" required>
                    </div>
                    <div class="form-group">
                        <label for="item-number">Number of People</label>
                        <input type="number" class="form-control" id="item-number" name="people_count" value="1" min="1" required>
                    </div>
                    {{-- <div class="form-group">
                        <label for="total-price">Total Price</label>
                        <input type="text" class="form-control" id="total-price" name="total_price" readonly>
                    </div> --}}
                    {{-- <button type="submit" class="btn btn-primary">{{ auth()->user()->hasFavoritedMeal($meal->id) ? 'Favorited' : 'Add to Favorites' }}</button> --}}
                    @auth
                    
                    @if(Auth::user()->user_type =='premium')
                    <button type="submit" class="btn btn-primary">Order</button>

                    @endif 

                    @endauth
                        
                </form>
            </div>
        </div>
        </div>
    </div>

    <div class="container">


  <div class="row">
    <form action="{{route('store-review',$item->id)}}" method="POST" class="mx-auto col-6">
        @csrf
        <h1 class="text-start">
            Review 
        </h1>
    
        <input type="text" name="content">
        <button type="submit">
            Submit 
        </button>
    </form>
  </div>
  <div>
    <ul class="">
        @foreach ($item->reviews as $item)
            <li class="">
                {{$item->content}} by {{$item->user->name}} at 
        
          <div class=" flex ">
            @if ($item->user_id == Auth::user()->id)
            
                
                <a href="{{route('edit-review' , $item->id)}}" class=" btn-info btn   text-decoration-none p-2  button ">Edit</a>
            
            @endif
            @if ($item->user_id == Auth::user()->id)
          

                <form action="{{route('delete-review' , $item->id)}}"   method="POST">
                    
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger">
                        Delete</button>    
                </form>
        
        @endif
          </div>

            </li>
        @endforeach
    </ul>
  </div>
</div>

    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     function calculateTotalPrice() {
        //         var price = parseFloat(document.getElementById('meal-price').textContent);
        //         var itemNumber = parseInt(document.getElementById('item-number').value);
        //         var totalPrice = price * itemNumber;
        //         document.getElementById('total-price').value = totalPrice.toFixed(2);
        //     }

        //     // Initial calculation
        //     calculateTotalPrice();

        //     // Recalculate total price on item number change
        //     document.getElementById('item-number').addEventListener('input', function() {
                
        //         calculateTotalPrice();
        //     });
        // });
    </script>
@endsection
