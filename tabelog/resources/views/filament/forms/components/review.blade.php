
<body>
    <div class="container mt-5">
        @if (count($reviews) > 0)
            <div class="card">
                <div class="card-header">
                    <h3>Reviews</h3>
                </div>
                <ul class="">
                    @foreach ($reviews as $review)
                        <li class="px-6 py-4">
                            {{$review->content}}
                        </li>
                    @endforeach
                </ul>
                </ul>
            </div>
        @else
            <div class="alert alert-info">
                No reviews available.
            </div>
        @endif
    </div>

  
