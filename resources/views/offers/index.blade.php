@extends('canvas')
@section('title', 'All Offers')
@section('title_header', 'Listing all offers of Maraîcher-ESI')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/allOffers.css') }}">
@endsection

@section('content')
    <table id="offers_list">

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Price</th>
            <th>Time left</th>
            <th>Provider</th>
            <th>Action</th>
        </tr>

        @foreach($offers as $offer)
            <tr>
                <td>{{$offer->id}}</td>
                <td>{{$offer->title}}</td>
                <td>{{$offer->price}}</td>
                <td>{{$offer->expirationDate}}</td>
                <td>{{$offer->address}}</td>
                <td>{{$offer->user_id}}</td>
                <td>
                    <form action="/buy/{{$offer->id}}" method="POST">
                        @CSRF
                        <button class="btn btn-green">Buy</button>
                    </form>
                </td>
            </tr>
        @endforeach

    </table>
@endsection()
