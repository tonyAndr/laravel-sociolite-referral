@extends('layouts.public')
 
@section('title', 'Раздача')
@section('description', 'Page desc')

@section('content')
    <input id='countdown_time' hidden type='number' value='{{$countdown_time}}'/>
    @include("giveaway.step$step")

@endsection

