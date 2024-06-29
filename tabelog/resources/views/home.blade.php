@extends('layouts/app')

@section('title')
    Home
@endsection

@section('content')
<div class="container mt-5">
    <div class="row">
        <?php 
        use App\Models\Store;
        $categories  = Store::categories();

        ?>
        
        <h1>Favorites</h1>
     @auth
     {{-- --------------------------- --}}
     @foreach (auth()->user()->favoriteStores as $item)
     <div class="col-12 col-md-6 col-lg-4 my-4">
        <div class="card">
            <div class="card-body d-flex flex-row">
                <h5 class="card-title font-weight-bold mb-2">{{ $item->name }}</h5>
            </div>
            <div class="bg-image hover-overlay ripple rounded-0" data-mdb-ripple-color="light">
                <a href="{{ route('meals.show', $item->id) }}">
                    <img class="img-fluid" src="{{ asset('stores').'/'.$item->image }}" />
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
     @endforeach
     {{-- --------------------------- --}}


     @endauth
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Category
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach ($categories as $category)
                <a class="dropdown-item" href="{{ route('home', ['category' => $category['id']]) }}">
               {{$category['category_name']}}
                </a>
                @endforeach
            </div>
        </div>

        <div>
            <form action="{{route('SearchBystoreName')}}" method="GET" class=" mt-3">
                @csrf
                <input type="text" name="storename">
                <button type="submit" class=" btn btn-info">Search </button>
            </form>
        </div>

        @foreach ($stores as $item)
        <div class="col-12 col-md-6 col-lg-4 my-4">
            <div class="card">
                <div class="card-body d-flex flex-row">
                    <h5 class="card-title font-weight-bold mb-2">{{ $item->name }}</h5>
                </div>
                <div class="bg-image hover-overlay ripple rounded-0" data-mdb-ripple-color="light">
                    <a href="{{ route('meals.show', $item->id) }}">
                        <img class="img-fluid" src="{{ asset('stores').'/'.$item->image }}" />
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
        @endforeach
    </div>
</div>
@endsection
