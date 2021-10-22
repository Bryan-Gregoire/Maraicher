@extends('canvas')
@section('title', 'All Offers')
@section('title_header', 'Listing all offers of Maraîcher-ESI')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/allOffers.css') }}">
@endsection

@section('content')
    {{dd($offers)}}
    <table id="offers_list">
        @foreach($offers as $offer)
            <tr>
                <td>{{$offer->id}}</td>
                <td>{{$offer->title}}</td>
                <td>{{$offer->price}}</td>
                <td>{{$offer->expirationDate}}</td>
                <td>{{$offer->address}}</td>
                <td>{{$offer->user_id}}</td>
            </tr>
        @endforeach
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Price</th>
            <th>Time left</th>
            <th>Provider</th>
            <th>Action</th>
        </tr>

        <tr>
            <td>1</td>
            <td>Légumes</td>
            <td>10x</td>
            <td>15 €</td>
            <td>5 days</td>
            <td>Billal ZIDI</td>
            <td>
                <form action="/buy" type="POST">
                    @CSRF
                    <button class="btn btn-green">Buy</button>
                </form>
            </td>
        </tr>

        <tr>
            <td>2</td>
            <td>Fruits</td>
            <td>1x</td>
            <td>1 €</td>
            <td>1 day</td>
            <td>Dylan BRICAR</td>
            <td>
                <form action="/buy" method="POST">
                    @CSRF
                    <button class="btn btn-green">Buy</button>
                </form>
            </td>
        </tr>
    </table>
@endsection()
