@extends('canvas')
@section('title', 'All Offers')
@section('title_header', 'Listing all offers of Maraîcher-ESI')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/allOffers.css') }}">
@endsection

@section('content')
    <div id="details">
        <form action="{{ route('reservations.select') }}" method="post">
            @csrf
            <label for="chosenCustomer">Potential clients</label>
            <select name="chosenCustomer" id="chosenCustomer">
                @foreach($reservation->users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
            <input type="hidden" name="offerId" value="{{$reservation->offer->id}}">
            <button type="submit">Choose this buyer !</button>
        </form>
    </>
@endsection()
