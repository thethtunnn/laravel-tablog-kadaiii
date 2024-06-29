@extends('layouts.app')

@section('content')
<?php 
$user = Auth::user();

?>
<div>
    @if ($user->user_type == 'premium')

        You are premium member .
        
    @elseif ($user->user_type == 'normal')
    apply for premium .
    @endif

</div>
<h1>
    @if ($user->user_type == 'premium')

    @elseif ($user->user_type == 'normal')
    To becom premium member ,  you need to pay for 300  each month 
    @endif
</h1>
@if(Auth::user()->user_type == 'normal')
<form action="{{route('users.apply_permium')}}" method="POST" class="from">
    @csrf
    <input type="number" value="300" readonly class=" form-control-input">
    <button class=" btn-primary">
        pay 
    </button>
</form>
@elseif(Auth::user()->user_type == 'premium')
<form action="{{route('cancelPlan')}}" method="POST">
    @csrf
    <button class=" btn-danger "> Cancel Plan </button>
</form>
@endif 

@endsection
