@extends('canvas')
@section('title', 'All Offers')
@section('title_header', 'Listing all offers of Maraîcher-ESI')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/allOffers.css') }}">
@endsection

@section('content')
    <table id="offers_list">

        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Expiration Date</th>
            <th>Offer address</th>
            <th>User</th>
            <th>Action</th>
        </tr>

        @foreach($offers as $offer)
            <tr>
                <td>{{$offer->title}}</td>
                <td>{{$offer->quantity}}</td>
                <td>{{$offer->price}} €</td>
                <td>{{date_format(new DateTime($offer->expirationDate),'g:ia \o\n l jS F Y')}}</td>
                <td>{{$offer->address}}</td>
                <td>{{$offer->user->name}}</td>
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
