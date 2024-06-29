@extends('layouts.app')

@section('content')

<form action="{{route('update-review')}}" method="POST">
    @csrf
    <input value="{{$review->content}}" type="text" name="content">
    <input type="hidden" value="{{$review->id}}" name="review_id" >
    <button type="submit" >Update</button>
</form>
@endsection